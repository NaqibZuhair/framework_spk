<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criterion;
use App\Models\JuryCriterion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class JuryCriterionController extends Controller
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

    private function baseQuery(Request $request)
    {
        $query = JuryCriterion::query()
            ->from('jury_criteria')
            ->join('users', 'jury_criteria.user_id', '=', 'users.id')
            ->join('criteria', 'jury_criteria.criterion_id', '=', 'criteria.id')
            ->join('election_periods', 'jury_criteria.period_id', '=', 'election_periods.id')
            ->select(
                'jury_criteria.*',
                'users.name as jury_name',
                'users.email as jury_email',
                'users.phone as jury_phone',
                'users.is_active as jury_is_active',
                'criteria.code as criterion_code',
                'criteria.name as criterion_name',
                'criteria.weight',
                'criteria.type',
                'criteria.min_score',
                'criteria.max_score',
                'criteria.is_active as criterion_is_active',
                'election_periods.election_year'
            );

        if ($request->user() && $request->user()->role === 'juri') {
            $query->where('jury_criteria.user_id', $request->user()->id);
        }

        return $query;
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'criterion_id' => ['nullable', 'integer', 'exists:criteria,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $query = $this->baseQuery($request);

        if ($request->user() && $request->user()->role === 'admin' && $request->filled('user_id')) {
            $query->where('jury_criteria.user_id', $request->user_id);
        }

        if ($request->filled('period_id')) {
            $query->where('jury_criteria.period_id', $request->period_id);
        }

        if ($request->filled('criterion_id')) {
            $query->where('jury_criteria.criterion_id', $request->criterion_id);
        }

        $assignments = $query
            ->orderByDesc('jury_criteria.period_id')
            ->orderBy('users.name')
            ->orderBy('criteria.code')
            ->paginate($request->integer('per_page', 10));

        return $this->success($assignments, 'Data pembagian kriteria berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'criterion_id' => ['required', 'integer', 'exists:criteria,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $jury = DB::table('users')
            ->where('id', $request->user_id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('User yang dipilih bukan juri.', 422);
        }

        if (!$jury->is_active) {
            return $this->error('Akun juri sedang nonaktif.', 422);
        }

        $criterion = Criterion::find($request->criterion_id);

        if (!$criterion || (int) $criterion->period_id !== (int) $request->period_id) {
            return $this->error('Kriteria tidak sesuai dengan periode yang dipilih.', 422);
        }

        $exists = JuryCriterion::where('period_id', $request->period_id)
            ->where('user_id', $request->user_id)
            ->where('criterion_id', $request->criterion_id)
            ->exists();

        if ($exists) {
            return $this->error('Kriteria ini sudah ditugaskan kepada juri tersebut.', 409);
        }

        try {
            $assignment = JuryCriterion::create([
                'period_id' => $request->period_id,
                'user_id' => $request->user_id,
                'criterion_id' => $request->criterion_id,
            ]);

            $data = $this->baseQuery($request)
                ->where('jury_criteria.id', $assignment->id)
                ->first();

            return $this->success($data, 'Kriteria berhasil ditugaskan kepada juri.', 201);
        } catch (Throwable $e) {
            return $this->error('Pembagian kriteria gagal disimpan.', 500, $e->getMessage());
        }
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $assignment = $this->baseQuery($request)
            ->where('jury_criteria.id', $id)
            ->first();

        if (!$assignment) {
            return $this->error('Data pembagian kriteria tidak ditemukan.', 404);
        }

        return $this->success($assignment, 'Detail pembagian kriteria berhasil diambil.');
    }

    public function update(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $assignment = JuryCriterion::find($id);

        if (!$assignment) {
            return $this->error('Data pembagian kriteria tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['sometimes', 'required', 'integer', 'exists:election_periods,id'],
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'criterion_id' => ['sometimes', 'required', 'integer', 'exists:criteria,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = $request->input('period_id', $assignment->period_id);
        $userId = $request->input('user_id', $assignment->user_id);
        $criterionId = $request->input('criterion_id', $assignment->criterion_id);

        $jury = DB::table('users')
            ->where('id', $userId)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('User yang dipilih bukan juri.', 422);
        }

        if (!$jury->is_active) {
            return $this->error('Akun juri sedang nonaktif.', 422);
        }

        $criterion = Criterion::find($criterionId);

        if (!$criterion || (int) $criterion->period_id !== (int) $periodId) {
            return $this->error('Kriteria tidak sesuai dengan periode yang dipilih.', 422);
        }

        $duplicate = JuryCriterion::where('period_id', $periodId)
            ->where('user_id', $userId)
            ->where('criterion_id', $criterionId)
            ->where('id', '!=', $assignment->id)
            ->exists();

        if ($duplicate) {
            return $this->error('Kriteria ini sudah ditugaskan kepada juri tersebut.', 409);
        }

        try {
            $assignment->update([
                'period_id' => $periodId,
                'user_id' => $userId,
                'criterion_id' => $criterionId,
            ]);

            $data = $this->baseQuery($request)
                ->where('jury_criteria.id', $assignment->id)
                ->first();

            return $this->success($data, 'Pembagian kriteria berhasil diperbarui.');
        } catch (Throwable $e) {
            return $this->error('Pembagian kriteria gagal diperbarui.', 500, $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $assignment = JuryCriterion::find($id);

        if (!$assignment) {
            return $this->error('Data pembagian kriteria tidak ditemukan.', 404);
        }

        $hasScores = DB::table('scores')
            ->where('period_id', $assignment->period_id)
            ->where('user_id', $assignment->user_id)
            ->where('criterion_id', $assignment->criterion_id)
            ->exists();

        if ($hasScores) {
            return $this->error('Tugas kriteria tidak dapat dihapus karena juri sudah memberi nilai.', 409);
        }

        try {
            $assignment->delete();

            return $this->success(null, 'Pembagian kriteria berhasil dihapus.');
        } catch (Throwable $e) {
            return $this->error('Pembagian kriteria gagal dihapus.', 500, $e->getMessage());
        }
    }

    public function sync(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        if (!$request->has('criteria') && $request->has('criterion_ids')) {
            $request->merge([
                'criteria' => $request->input('criterion_ids'),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'criteria' => ['required', 'array', 'min:1'],
            'criteria.*' => ['required', 'integer', 'distinct', 'exists:criteria,id'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $jury = DB::table('users')
            ->where('id', $request->user_id)
            ->where('role', 'juri')
            ->first();

        if (!$jury) {
            return $this->error('User yang dipilih bukan juri.', 422);
        }

        if (!$jury->is_active) {
            return $this->error('Akun juri sedang nonaktif.', 422);
        }

        $criteriaIds = array_values(array_unique(array_map('intval', $request->input('criteria'))));

        $criteria = Criterion::whereIn('id', $criteriaIds)->get();

        if ($criteria->count() !== count($criteriaIds)) {
            return $this->error('Ada kriteria yang tidak ditemukan.', 422);
        }

        $invalidPeriod = $criteria
            ->where('period_id', '!=', (int) $request->period_id)
            ->count();

        if ($invalidPeriod > 0) {
            return $this->error('Semua kriteria harus berada pada periode yang sama.', 422);
        }

        $oldCriteriaIds = JuryCriterion::where('period_id', $request->period_id)
            ->where('user_id', $request->user_id)
            ->pluck('criterion_id')
            ->toArray();

        $removedCriteria = array_diff($oldCriteriaIds, $criteriaIds);

        if (!empty($removedCriteria)) {
            $hasScores = DB::table('scores')
                ->where('period_id', $request->period_id)
                ->where('user_id', $request->user_id)
                ->whereIn('criterion_id', $removedCriteria)
                ->exists();

            if ($hasScores) {
                return $this->error('Beberapa kriteria tidak dapat dihapus karena juri sudah memberi nilai.', 409);
            }
        }

        try {
            DB::transaction(function () use ($request, $criteriaIds) {
                JuryCriterion::where('period_id', $request->period_id)
                    ->where('user_id', $request->user_id)
                    ->whereNotIn('criterion_id', $criteriaIds)
                    ->delete();

                foreach ($criteriaIds as $criterionId) {
                    JuryCriterion::firstOrCreate([
                        'period_id' => $request->period_id,
                        'user_id' => $request->user_id,
                        'criterion_id' => $criterionId,
                    ]);
                }
            });

            $assignments = $this->baseQuery($request)
                ->where('jury_criteria.period_id', $request->period_id)
                ->where('jury_criteria.user_id', $request->user_id)
                ->orderBy('criteria.code')
                ->get();

            return $this->success($assignments, 'Daftar kriteria juri berhasil disinkronkan.');
        } catch (Throwable $e) {
            return $this->error('Sinkronisasi kriteria juri gagal.', 500, $e->getMessage());
        }
    }
}