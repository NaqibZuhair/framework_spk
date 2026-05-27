<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class InterviewController extends Controller
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

    private function interviewQuery()
    {
        return DB::table('interviews')
            ->join('candidates', 'interviews.candidate_id', '=', 'candidates.id')
            ->join('election_periods', 'interviews.period_id', '=', 'election_periods.id')
            ->leftJoin('users as creators', 'interviews.created_by', '=', 'creators.id')
            ->select(
                'interviews.*',
                'candidates.registration_number',
                'candidates.full_name',
                'candidates.student_number',
                'candidates.email',
                'candidates.phone',
                'candidates.faculty',
                'candidates.study_program',
                'candidates.semester',
                'candidates.status as candidate_status',
                'election_periods.election_year',
                'creators.name as created_by_name'
            );
    }

    private function candidateStatusFromInterviewStatus(string $status, string $fallback = 'valid'): string
    {
        return match ($status) {
            'scheduled' => 'interview_scheduled',
            'completed' => 'interviewed',
            'absent', 'cancelled' => 'valid',
            default => $fallback,
        };
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'period_id' => ['nullable', 'integer', 'exists:election_periods,id'],
            'status' => ['nullable', Rule::in(['scheduled', 'completed', 'absent', 'cancelled'])],
            'date' => ['nullable', 'date'],
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $query = $this->interviewQuery();

        if ($request->filled('period_id')) {
            $query->where('interviews.period_id', $request->period_id);
        }

        if ($request->filled('status')) {
            $query->where('interviews.status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('interviews.scheduled_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('candidates.full_name', 'like', "%{$search}%")
                    ->orWhere('candidates.student_number', 'like', "%{$search}%")
                    ->orWhere('candidates.registration_number', 'like', "%{$search}%");
            });
        }

        $interviews = $query
            ->orderBy('interviews.scheduled_at')
            ->paginate($request->integer('per_page', 10));

        return $this->success($interviews, 'Data jadwal wawancara berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $validator = Validator::make($request->all(), [
            'candidate_id' => ['required', 'integer', 'exists:candidates,id'],
            'scheduled_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['scheduled', 'completed', 'absent', 'cancelled'])],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        $candidate = DB::table('candidates')
            ->where('id', $request->candidate_id)
            ->first();

        if (!$candidate) {
            return $this->error('Calon tidak ditemukan.', 404);
        }

        if ($candidate->status !== 'valid') {
            return $this->error('Calon harus berstatus valid sebelum dijadwalkan wawancara.', 422);
        }

        $alreadyScheduled = DB::table('interviews')
            ->where('candidate_id', $request->candidate_id)
            ->exists();

        if ($alreadyScheduled) {
            return $this->error('Calon ini sudah memiliki jadwal wawancara.', 409);
        }

        try {
            $now = now();
            $status = $request->input('status', 'scheduled');

            $id = DB::table('interviews')->insertGetId([
                'period_id' => $candidate->period_id,
                'candidate_id' => $candidate->id,
                'scheduled_at' => $request->scheduled_at,
                'location' => $request->input('location'),
                'status' => $status,
                'created_by' => $request->user()->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('candidates')
                ->where('id', $candidate->id)
                ->update([
                    'status' => $this->candidateStatusFromInterviewStatus($status, $candidate->status),
                    'updated_at' => $now,
                ]);

            $interview = $this->interviewQuery()
                ->where('interviews.id', $id)
                ->first();

            return $this->success($interview, 'Jadwal wawancara berhasil dibuat.', 201);
        } catch (Throwable $e) {
            return $this->error('Jadwal wawancara gagal dibuat.', 500, $e->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        $interview = $this->interviewQuery()
            ->where('interviews.id', $id)
            ->first();

        if (!$interview) {
            return $this->error('Jadwal wawancara tidak ditemukan.', 404);
        }

        return $this->success($interview, 'Detail jadwal wawancara berhasil diambil.');
    }

    public function update(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $interview = DB::table('interviews')
            ->where('id', $id)
            ->first();

        if (!$interview) {
            return $this->error('Jadwal wawancara tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'candidate_id' => ['sometimes', 'required', 'integer', 'exists:candidates,id'],
            'scheduled_at' => ['sometimes', 'required', 'date'],
            'location' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'required', Rule::in(['scheduled', 'completed', 'absent', 'cancelled'])],
        ]);

        if ($validator->fails()) {
            return $this->error('Validasi gagal.', 422, $validator->errors());
        }

        try {
            $now = now();
            $candidateId = $request->input('candidate_id', $interview->candidate_id);
            $periodId = $interview->period_id;

            if ((int) $candidateId !== (int) $interview->candidate_id) {
                $newCandidate = DB::table('candidates')
                    ->where('id', $candidateId)
                    ->first();

                if (!$newCandidate) {
                    return $this->error('Calon pengganti tidak ditemukan.', 404);
                }

                if ($newCandidate->status !== 'valid') {
                    return $this->error('Calon pengganti harus berstatus valid.', 422);
                }

                $used = DB::table('interviews')
                    ->where('candidate_id', $candidateId)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($used) {
                    return $this->error('Calon pengganti sudah memiliki jadwal wawancara.', 409);
                }

                $oldCandidate = DB::table('candidates')
                    ->where('id', $interview->candidate_id)
                    ->first();

                if ($oldCandidate && in_array($oldCandidate->status, ['interview_scheduled', 'interviewed'], true)) {
                    DB::table('candidates')
                        ->where('id', $oldCandidate->id)
                        ->update([
                            'status' => 'valid',
                            'updated_at' => $now,
                        ]);
                }

                $periodId = $newCandidate->period_id;
            }

            $status = $request->input('status', $interview->status);

            $data = [
                'candidate_id' => $candidateId,
                'period_id' => $periodId,
                'updated_at' => $now,
            ];

            if ($request->has('scheduled_at')) {
                $data['scheduled_at'] = $request->scheduled_at;
            }

            if ($request->has('location')) {
                $data['location'] = $request->input('location');
            }

            if ($request->has('status')) {
                $data['status'] = $status;
            }

            DB::table('interviews')
                ->where('id', $id)
                ->update($data);

            $candidate = DB::table('candidates')
                ->where('id', $candidateId)
                ->first();

            if ($candidate) {
                DB::table('candidates')
                    ->where('id', $candidateId)
                    ->update([
                        'status' => $this->candidateStatusFromInterviewStatus($status, $candidate->status),
                        'updated_at' => $now,
                    ]);
            }

            $updated = $this->interviewQuery()
                ->where('interviews.id', $id)
                ->first();

            return $this->success($updated, 'Jadwal wawancara berhasil diperbarui.');
        } catch (Throwable $e) {
            return $this->error('Jadwal wawancara gagal diperbarui.', 500, $e->getMessage());
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($deny = $this->adminOnly($request)) {
            return $deny;
        }

        $interview = DB::table('interviews')
            ->where('id', $id)
            ->first();

        if (!$interview) {
            return $this->error('Jadwal wawancara tidak ditemukan.', 404);
        }

        try {
            $candidate = DB::table('candidates')
                ->where('id', $interview->candidate_id)
                ->first();

            DB::table('interviews')
                ->where('id', $id)
                ->delete();

            if ($candidate && in_array($candidate->status, ['interview_scheduled', 'interviewed'], true)) {
                DB::table('candidates')
                    ->where('id', $candidate->id)
                    ->update([
                        'status' => 'valid',
                        'updated_at' => now(),
                    ]);
            }

            return $this->success(null, 'Jadwal wawancara berhasil dihapus.');
        } catch (Throwable $e) {
            return $this->error('Jadwal wawancara gagal dihapus.', 500, $e->getMessage());
        }
    }
}