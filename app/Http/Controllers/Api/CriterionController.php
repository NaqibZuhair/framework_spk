<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
            'is_active' => ['nullable', 'boolean'],
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $query = DB::table('criteria')
            ->join('election_periods', 'criteria.period_id', '=', 'election_periods.id')
            ->select(
                'criteria.*',
                'election_periods.election_year'
            );

        if ($user && $user->role === 'juri') {
            $query->join('jury_criteria', function ($join) use ($user) {
                $join->on('criteria.id', '=', 'jury_criteria.criterion_id')
                    ->where('jury_criteria.user_id', '=', $user->id);
            });

            $query->distinct();
        }

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
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('criteria', 'code')->where(fn ($query) => $query->where('period_id', $request->period_id)),
            ],
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('criteria', 'name')->where(fn ($query) => $query->where('period_id', $request->period_id)),
            ],
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

        try {
            $now = now();

            $id = DB::table('criteria')->insertGetId([
                'period_id' => $request->period_id,
                'code' => strtoupper(trim($request->code)),
                'name' => trim($request->name),
                'weight' => $request->weight,
                'type' => $request->type,
                'min_score' => $request->input('min_score', 0),
                'max_score' => $request->input('max_score', 100),
                'is_active' => $request->boolean('is_active', true),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $criterion = DB::table('criteria')->where('id', $id)->first();

            return $this->success($criterion, 'Kriteria berhasil ditambahkan.', 201);
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal ditambahkan.', 500, $e->getMessage());
        }
    }

    public function show(string $id, Request $request): JsonResponse
    {
        $user = $request->user();

        $query = DB::table('criteria')
            ->join('election_periods', 'criteria.period_id', '=', 'election_periods.id')
            ->select(
                'criteria.*',
                'election_periods.election_year'
            )
            ->where('criteria.id', $id);

        if ($user && $user->role === 'juri') {
            $query->join('jury_criteria', function ($join) use ($user) {
                $join->on('criteria.id', '=', 'jury_criteria.criterion_id')
                    ->where('jury_criteria.user_id', '=', $user->id);
            });
        }

        $criterion = $query->first();

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

        $criterion = DB::table('criteria')->where('id', $id)->first();

        if (!$criterion) {
            return $this->error('Kriteria tidak ditemukan.', 404);
        }

        $periodId = $request->input('period_id', $criterion->period_id);

        $validator = Validator::make($request->all(), [
            'period_id' => ['sometimes', 'required', 'integer', 'exists:election_periods,id'],
            'code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('criteria', 'code')
                    ->where(fn ($query) => $query->where('period_id', $periodId))
                    ->ignore($id),
            ],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                Rule::unique('criteria', 'name')
                    ->where(fn ($query) => $query->where('period_id', $periodId))
                    ->ignore($id),
            ],
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

        try {
            $data = [
                'updated_at' => now(),
            ];

            foreach (['period_id', 'code', 'name', 'weight', 'type', 'min_score', 'max_score', 'is_active'] as $field) {
                if ($request->has($field)) {
                    $data[$field] = $field === 'code'
                        ? strtoupper(trim($request->input($field)))
                        : $request->input($field);
                }
            }

            if ($request->has('name')) {
                $data['name'] = trim($request->name);
            }

            if ($request->has('is_active')) {
                $data['is_active'] = $request->boolean('is_active');
            }

            DB::table('criteria')->where('id', $id)->update($data);

            $updated = DB::table('criteria')->where('id', $id)->first();

            return $this->success($updated, 'Kriteria berhasil diperbarui.');
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal diperbarui.', 500, $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $criterion = DB::table('criteria')->where('id', $id)->first();

        if (!$criterion) {
            return $this->error('Kriteria tidak ditemukan.', 404);
        }

        $hasScores = DB::table('scores')->where('criterion_id', $id)->exists();

        if ($hasScores) {
            return $this->error('Kriteria tidak dapat dihapus karena sudah memiliki data nilai.', 409);
        }

        try {
            DB::table('criteria')->where('id', $id)->delete();

            return $this->success(null, 'Kriteria berhasil dihapus.');
        } catch (Throwable $e) {
            return $this->error('Kriteria gagal dihapus.', 500, $e->getMessage());
        }
    }
}