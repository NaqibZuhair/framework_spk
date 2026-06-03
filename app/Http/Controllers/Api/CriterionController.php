<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criterion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class CriterionController extends Controller
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
        $query = Criterion::query()
            ->from('criteria')
            ->join('election_periods', 'criteria.period_id', '=', 'election_periods.id')
            ->select(
                'criteria.*',
                'election_periods.election_year',
                'election_periods.status as period_status'
            );

        if ($request->user() && $request->user()->role === 'juri') {
            $query->join('jury_criteria', function ($join) use ($request) {
                $join->on('criteria.id', '=', 'jury_criteria.criterion_id')
                    ->where('jury_criteria.user_id', '=', $request->user()->id);
            });

            $query->distinct();
        }

        return $query;
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
            'is_active' => ['nullable', 'boolean'],
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $query = $this->baseQuery($request);

        if ($request->filled('period_id')) {
            $query->where('criteria.period_id', $request->period_id);
        }

        if ($request->has('is_active')) {
            $query->where('criteria.is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('criteria.code', 'like', "%{$search}%")
                    ->orWhere('criteria.name', 'like', "%{$search}%");
            });
        }

        $criteria = $query
            ->orderByDesc('criteria.period_id')
            ->orderBy('criteria.code')
            ->paginate($request->integer('per_page', 10));

        return $this->success($criteria, 'Data kriteria berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:150'],
            'weight' => ['required', 'numeric', 'min:0'],
            'type' => ['required', Rule::in(['benefit', 'cost'])],
            'min_score' => ['nullable', 'numeric', 'min:0'],
            'max_score' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $minScore = (float) $request->input('min_score', 0);
            $maxScore = (float) $request->input('max_score', 100);

            if ($minScore >= $maxScore) {
                $validator->errors()->add('max_score', 'Nilai maksimal harus lebih besar dari nilai minimal.');
            }
        });

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $code = strtoupper(trim($request->code));
        $name = trim($request->name);

        $codeExists = Criterion::where('period_id', $request->period_id)
            ->where('code', $code)
            ->exists();

        if ($codeExists) {
            return $this->error('Kode kriteria sudah digunakan pada periode ini.', 422);
        }

        $nameExists = Criterion::where('period_id', $request->period_id)
            ->where('name', $name)
            ->exists();

        if ($nameExists) {
            return $this->error('Nama kriteria sudah digunakan pada periode ini.', 422);
        }

        try {
            $criterion = Criterion::create([
                'period_id' => $request->period_id,
                'code' => $code,
                'name' => $name,
                'weight' => $request->weight,
                'type' => $request->type,
                'min_score' => $request->input('min_score', 0),
                'max_score' => $request->input('max_score', 100),
                'is_active' => $request->boolean('is_active', true),
            ]);

            return $this->success($criterion, 'Kriteria berhasil ditambahkan.', 201);
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal ditambahkan.', 500, $e->getMessage());
        }
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $criterion = $this->baseQuery($request)
            ->where('criteria.id', $id)
            ->first();

        if (!$criterion) {
            return $this->error('Kriteria tidak ditemukan.', 404);
        }

        return $this->success($criterion, 'Detail kriteria berhasil diambil.');
    }

    public function update(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $criterion = Criterion::find($id);

        if (!$criterion) {
            return $this->error('Kriteria tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['sometimes', 'required', 'integer', 'exists:election_periods,id'],
            'code' => ['sometimes', 'required', 'string', 'max:50'],
            'name' => ['sometimes', 'required', 'string', 'max:150'],
            'weight' => ['sometimes', 'required', 'numeric', 'min:0'],
            'type' => ['sometimes', 'required', Rule::in(['benefit', 'cost'])],
            'min_score' => ['sometimes', 'required', 'numeric', 'min:0'],
            'max_score' => ['sometimes', 'required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'required', 'boolean'],
        ]);

        $validator->after(function ($validator) use ($request, $criterion) {
            $minScore = (float) $request->input('min_score', $criterion->min_score);
            $maxScore = (float) $request->input('max_score', $criterion->max_score);

            if ($minScore >= $maxScore) {
                $validator->errors()->add('max_score', 'Nilai maksimal harus lebih besar dari nilai minimal.');
            }
        });

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = $request->input('period_id', $criterion->period_id);
        $code = strtoupper(trim($request->input('code', $criterion->code)));
        $name = trim($request->input('name', $criterion->name));

        $codeExists = Criterion::where('period_id', $periodId)
            ->where('code', $code)
            ->where('id', '!=', $criterion->id)
            ->exists();

        if ($codeExists) {
            return $this->error('Kode kriteria sudah digunakan pada periode ini.', 422);
        }

        $nameExists = Criterion::where('period_id', $periodId)
            ->where('name', $name)
            ->where('id', '!=', $criterion->id)
            ->exists();

        if ($nameExists) {
            return $this->error('Nama kriteria sudah digunakan pada periode ini.', 422);
        }

        try {
            $criterion->update([
                'period_id' => $periodId,
                'code' => $code,
                'name' => $name,
                'weight' => $request->input('weight', $criterion->weight),
                'type' => $request->input('type', $criterion->type),
                'min_score' => $request->input('min_score', $criterion->min_score),
                'max_score' => $request->input('max_score', $criterion->max_score),
                'is_active' => $request->has('is_active')
                    ? $request->boolean('is_active')
                    : $criterion->is_active,
            ]);

            return $this->success($criterion->fresh(), 'Kriteria berhasil diperbarui.');
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal diperbarui.', 500, $e->getMessage());
        }
    }

    public function sync(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'period_id' => ['required', 'integer', 'exists:election_periods,id'],
            'criteria' => ['required', 'array', 'min:1'],

            'criteria.*.id' => ['nullable', 'integer', 'exists:criteria,id'],
            'criteria.*.code' => ['required', 'string', 'max:50'],
            'criteria.*.name' => ['required', 'string', 'max:150'],
            'criteria.*.weight' => ['required', 'numeric', 'min:0'],
            'criteria.*.type' => ['required', Rule::in(['benefit', 'cost'])],
            'criteria.*.min_score' => ['nullable', 'numeric', 'min:0'],
            'criteria.*.max_score' => ['required', 'numeric', 'min:0'],
            'criteria.*.is_active' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $periodId = (int) $request->period_id;
        $rows = $request->criteria;

        $normalizedRows = [];
        $codes = [];
        $names = [];
        $activeWeightTotal = 0;

        foreach ($rows as $index => $row) {
            $id = $row['id'] ?? null;
            $code = strtoupper(trim($row['code']));
            $name = trim($row['name']);
            $nameKey = strtolower($name);
            $weight = (float) $row['weight'];
            $type = $row['type'];
            $minScore = (float) ($row['min_score'] ?? 0);
            $maxScore = (float) $row['max_score'];
            $isActive = filter_var($row['is_active'], FILTER_VALIDATE_BOOLEAN);

            if ($code === '') {
                return $this->error('Kode kriteria pada baris ' . ($index + 1) . ' wajib diisi.', 422);
            }

            if ($name === '') {
                return $this->error('Nama kriteria pada baris ' . ($index + 1) . ' wajib diisi.', 422);
            }

            if ($minScore >= $maxScore) {
                return $this->error('Nilai maksimal harus lebih besar dari nilai minimal pada baris ' . ($index + 1) . '.', 422);
            }

            if (isset($codes[$code])) {
                return $this->error('Kode kriteria ' . $code . ' digunakan lebih dari satu kali.', 422);
            }

            if (isset($names[$nameKey])) {
                return $this->error('Nama kriteria "' . $name . '" digunakan lebih dari satu kali.', 422);
            }

            $codes[$code] = true;
            $names[$nameKey] = true;

            if ($isActive) {
                $activeWeightTotal += $weight;
            }

            $normalizedRows[] = [
                'id' => $id ? (int) $id : null,
                'period_id' => $periodId,
                'code' => $code,
                'name' => $name,
                'weight' => $weight,
                'type' => $type,
                'min_score' => $minScore,
                'max_score' => $maxScore,
                'is_active' => $isActive,
            ];
        }

        if (abs($activeWeightTotal - 1) > 0.0001) {
            return $this->error(
                'Total bobot kriteria aktif harus 100%. Total saat ini: ' . number_format($activeWeightTotal * 100, 2) . '%.',
                422
            );
        }

        $incomingIds = collect($normalizedRows)
            ->pluck('id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->toArray();

        if (!empty($incomingIds)) {
            $validExistingCount = Criterion::where('period_id', $periodId)
                ->whereIn('id', $incomingIds)
                ->count();

            if ($validExistingCount !== count($incomingIds)) {
                return $this->error('Ada kriteria yang tidak sesuai dengan periode yang dipilih.', 422);
            }
        }

        $existingIds = Criterion::where('period_id', $periodId)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $deleteIds = array_values(array_diff($existingIds, $incomingIds));

        if (!empty($deleteIds)) {
            $usedCriteria = DB::table('scores')
                ->whereIn('criterion_id', $deleteIds)
                ->exists();

            if ($usedCriteria) {
                return $this->error('Beberapa kriteria tidak dapat dihapus karena sudah memiliki data nilai.', 409);
            }
        }

        try {
            DB::transaction(function () use ($periodId, $normalizedRows, $deleteIds) {
                if (!empty($deleteIds)) {
                    DB::table('jury_criteria')
                        ->whereIn('criterion_id', $deleteIds)
                        ->delete();

                    Criterion::where('period_id', $periodId)
                        ->whereIn('id', $deleteIds)
                        ->delete();
                }

                foreach ($normalizedRows as $row) {
                    if ($row['id']) {
                        Criterion::where('period_id', $periodId)
                            ->where('id', $row['id'])
                            ->update([
                                'code' => $row['code'],
                                'name' => $row['name'],
                                'weight' => $row['weight'],
                                'type' => $row['type'],
                                'min_score' => $row['min_score'],
                                'max_score' => $row['max_score'],
                                'is_active' => $row['is_active'],
                                'updated_at' => now(),
                            ]);
                    } else {
                        Criterion::create([
                            'period_id' => $periodId,
                            'code' => $row['code'],
                            'name' => $row['name'],
                            'weight' => $row['weight'],
                            'type' => $row['type'],
                            'min_score' => $row['min_score'],
                            'max_score' => $row['max_score'],
                            'is_active' => $row['is_active'],
                        ]);
                    }
                }
            });

            $criteria = $this->baseQuery($request)
                ->where('criteria.period_id', $periodId)
                ->orderBy('criteria.code')
                ->get();

            return $this->success($criteria, 'Seluruh kriteria berhasil disimpan.');
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal disimpan.', 500, $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $criterion = Criterion::find($id);

        if (!$criterion) {
            return $this->error('Kriteria tidak ditemukan.', 404);
        }

        $hasScores = DB::table('scores')
            ->where('criterion_id', $criterion->id)
            ->exists();

        if ($hasScores) {
            return $this->error('Kriteria tidak dapat dihapus karena sudah memiliki data nilai.', 409);
        }

        try {
            $criterion->delete();

            return $this->success(null, 'Kriteria berhasil dihapus.');
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal dihapus.', 500, $e->getMessage());
        }
    }
}