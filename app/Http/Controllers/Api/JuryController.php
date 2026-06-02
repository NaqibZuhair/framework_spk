<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JuryCriterion;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class JuryController extends Controller
{
    private function success($data = null, string $message = 'Berhasil', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function error(string $message = 'Terjadi kesalahan', int $status = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    private function adminOnly(Request $request): ?JsonResponse
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return $this->error('Akses ditolak. Hanya admin yang dapat melakukan aksi ini.', 403);
        }

        return null;
    }

    private function getPeriodId(?int $periodId = null): ?int
    {
        if ($periodId) {
            return $periodId;
        }

        $period = DB::table('election_periods')
            ->orderByDesc('id')
            ->first();

        return $period?->id;
    }

    private function attachCriteriaToJuries($juries, int $periodId)
    {
        $juryIds = collect($juries)
            ->pluck('id')
            ->filter()
            ->values();

        if ($juryIds->isEmpty()) {
            return collect($juries);
        }

        $assignments = DB::table('jury_criteria')
            ->join('criteria', 'jury_criteria.criterion_id', '=', 'criteria.id')
            ->where('jury_criteria.period_id', $periodId)
            ->whereIn('jury_criteria.user_id', $juryIds)
            ->select(
                'jury_criteria.user_id',
                'criteria.id',
                'criteria.code',
                'criteria.name',
                'criteria.weight',
                'criteria.type',
                'criteria.min_score',
                'criteria.max_score',
                'criteria.is_active'
            )
            ->orderBy('criteria.code')
            ->get()
            ->groupBy('user_id');

        return collect($juries)->map(function ($jury) use ($assignments) {
            $criteria = $assignments->get($jury->id, collect())->values();

            $jury->criteria = $criteria;
            $jury->criteria_count = $criteria->count();
            $jury->criteria_codes = $criteria->pluck('code')->values();

            return $jury;
        })->values();
    }

    public function index(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = $this->getPeriodId($request->integer('period_id'));

        if (!$periodId) {
            return $this->error('Periode pemilihan belum tersedia.', 404);
        }

        $query = DB::table('users')
            ->where('role', 'juri')
            ->select(
                'id',
                'name',
                'email',
                'phone',
                'role',
                'is_active',
                'created_at',
                'updated_at'
            );

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        }

        if ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $paginated = $query
            ->orderBy('name')
            ->paginate($request->integer('per_page', 10));

        $paginated->setCollection(
            $this->attachCriteriaToJuries($paginated->getCollection(), $periodId)
        );

        return $this->success($paginated, 'Data akun juri berhasil diambil.');
    }

    public function options(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = $this->getPeriodId($request->integer('period_id'));

        if (!$periodId) {
            return $this->error('Periode pemilihan belum tersedia.', 404);
        }

        $period = DB::table('election_periods')
            ->where('id', $periodId)
            ->first();

        $criteria = DB::table('criteria')
            ->where('period_id', $periodId)
            ->orderBy('code')
            ->select(
                'id',
                'period_id',
                'code',
                'name',
                'weight',
                'type',
                'min_score',
                'max_score',
                'is_active'
            )
            ->get();

        return $this->success([
            'period' => $period,
            'criteria' => $criteria,
        ], 'Data pilihan juri berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'is_active' => ['required', 'boolean'],
            'criteria' => ['required', 'array', 'min:1'],
            'criteria.*' => ['required', 'integer', 'distinct', 'exists:criteria,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = (int) $request->period_id;
        $criteriaIds = array_values(array_unique(array_map('intval', $request->criteria)));

        $validCriteriaCount = DB::table('criteria')
            ->where('period_id', $periodId)
            ->whereIn('id', $criteriaIds)
            ->count();

        if ($validCriteriaCount !== count($criteriaIds)) {
            return $this->error('Semua kriteria harus sesuai dengan periode yang dipilih.', 422);
        }

        try {
            $jury = DB::transaction(function () use ($request, $periodId, $criteriaIds) {
                $jury = User::create([
                    'name' => trim($request->name),
                    'email' => strtolower(trim($request->email)),
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'role' => 'juri',
                    'is_active' => $request->boolean('is_active'),
                ]);

                foreach ($criteriaIds as $criterionId) {
                    JuryCriterion::create([
                        'period_id' => $periodId,
                        'user_id' => $jury->id,
                        'criterion_id' => $criterionId,
                    ]);
                }

                return $jury;
            });

            $data = $this->attachCriteriaToJuries(collect([$jury]), $periodId)->first();

            return $this->success($data, 'Akun juri berhasil ditambahkan.', 201);
        } catch (Throwable $e) {
            return $this->error('Akun juri gagal ditambahkan.', 500, $e->getMessage());
        }
    }

    public function show(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = $this->getPeriodId($request->integer('period_id'));

        if (!$periodId) {
            return $this->error('Periode pemilihan belum tersedia.', 404);
        }

        $jury = DB::table('users')
            ->where('id', $id)
            ->where('role', 'juri')
            ->select(
                'id',
                'name',
                'email',
                'phone',
                'role',
                'is_active',
                'created_at',
                'updated_at'
            )
            ->first();

        if (!$jury) {
            return $this->error('Akun juri tidak ditemukan.', 404);
        }

        $data = $this->attachCriteriaToJuries(collect([$jury]), $periodId)->first();

        return $this->success($data, 'Detail akun juri berhasil diambil.');
    }

    public function update(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $jury = User::where('id', $id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('Akun juri tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($jury->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'is_active' => ['required', 'boolean'],
            'criteria' => ['required', 'array', 'min:1'],
            'criteria.*' => ['required', 'integer', 'distinct', 'exists:criteria,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = (int) $request->period_id;
        $criteriaIds = array_values(array_unique(array_map('intval', $request->criteria)));

        $validCriteriaCount = DB::table('criteria')
            ->where('period_id', $periodId)
            ->whereIn('id', $criteriaIds)
            ->count();

        if ($validCriteriaCount !== count($criteriaIds)) {
            return $this->error('Semua kriteria harus sesuai dengan periode yang dipilih.', 422);
        }

        $oldCriteriaIds = JuryCriterion::where('period_id', $periodId)
            ->where('user_id', $jury->id)
            ->pluck('criterion_id')
            ->toArray();

        $removedCriteria = array_diff($oldCriteriaIds, $criteriaIds);

        if (!empty($removedCriteria)) {
            $hasScores = DB::table('scores')
                ->where('period_id', $periodId)
                ->where('user_id', $jury->id)
                ->whereIn('criterion_id', $removedCriteria)
                ->exists();

            if ($hasScores) {
                return $this->error('Beberapa kriteria tidak dapat dihapus karena juri sudah memberi nilai.', 409);
            }
        }

        try {
            DB::transaction(function () use ($request, $jury, $periodId, $criteriaIds) {
                $updateData = [
                    'name' => trim($request->name),
                    'email' => strtolower(trim($request->email)),
                    'phone' => $request->phone,
                    'is_active' => $request->boolean('is_active'),
                ];

                if ($request->filled('password')) {
                    $updateData['password'] = $request->password;
                }

                $jury->update($updateData);

                JuryCriterion::where('period_id', $periodId)
                    ->where('user_id', $jury->id)
                    ->whereNotIn('criterion_id', $criteriaIds)
                    ->delete();

                foreach ($criteriaIds as $criterionId) {
                    JuryCriterion::firstOrCreate([
                        'period_id' => $periodId,
                        'user_id' => $jury->id,
                        'criterion_id' => $criterionId,
                    ]);
                }
            });

            $fresh = User::where('id', $jury->id)
                ->where('role', 'juri')
                ->first();

            $data = $this->attachCriteriaToJuries(collect([$fresh]), $periodId)->first();

            return $this->success($data, 'Akun juri berhasil diperbarui.');
        } catch (Throwable $e) {
            return $this->error('Akun juri gagal diperbarui.', 500, $e->getMessage());
        }
    }

    public function resetPassword(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $jury = User::where('id', $id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('Akun juri tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $jury->update([
            'password' => $request->password,
        ]);

        return $this->success(null, 'Password akun juri berhasil direset.');
    }

    public function toggleStatus(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $jury = User::where('id', $id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('Akun juri tidak ditemukan.', 404);
        }

        $jury->update([
            'is_active' => !$jury->is_active,
        ]);

        return $this->success([
            'id' => $jury->id,
            'is_active' => (bool) $jury->fresh()->is_active,
        ], 'Status akun juri berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $jury = User::where('id', $id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('Akun juri tidak ditemukan.', 404);
        }

        $hasScores = DB::table('scores')
            ->where('user_id', $jury->id)
            ->exists();

        if ($hasScores) {
            $jury->update([
                'is_active' => false,
            ]);

            return $this->success(null, 'Akun juri sudah memiliki nilai, sehingga akun dinonaktifkan.');
        }

        try {
            DB::transaction(function () use ($jury) {
                JuryCriterion::where('user_id', $jury->id)->delete();
                $jury->delete();
            });

            return $this->success(null, 'Akun juri berhasil dihapus.');
        } catch (Throwable $e) {
            return $this->error('Akun juri gagal dihapus.', 500, $e->getMessage());
        }
    }
}