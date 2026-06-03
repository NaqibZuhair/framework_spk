<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criterion;
use App\Models\JuryCriterion;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::with([
            'candidate',
            'criterion',
            'jury',
            'period'
        ])->get();

        return response()->json([
            'message' => 'Data score berhasil diambil.',
            'data' => $scores
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:election_periods,id',
            'candidate_id' => 'required|exists:candidates,id',
            'criterion_id' => 'required|exists:criteria,id',
            'score' => 'required|numeric',
        ]);

        $juryId = Auth::id();

        // Pastikan kriteria memang tugas juri
        $assigned = JuryCriterion::where('user_id', $juryId)
            ->where('criterion_id', $request->criterion_id)
            ->exists();

        if (!$assigned) {
            return response()->json([
                'message' => 'Kriteria ini bukan tugas Anda.'
            ], 403);
        }

        // Ambil data kriteria
        $criterion = Criterion::findOrFail(
            $request->criterion_id
        );

        // Validasi rentang nilai
        if (
            $request->score < $criterion->min_score ||
            $request->score > $criterion->max_score
        ) {
            return response()->json([
                'message' => 'Nilai berada di luar batas yang diperbolehkan.'
            ], 422);
        }

        // Cek apakah sudah pernah menilai
        $exists = Score::where(
            'candidate_id',
            $request->candidate_id
        )
        ->where(
            'user_id',
            $juryId
        )
        ->where(
            'criterion_id',
            $request->criterion_id
        )
        ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Anda sudah memberikan nilai untuk kriteria ini.'
            ], 422);
        }

        $score = Score::create([
            'period_id' => $request->period_id,
            'candidate_id' => $request->candidate_id,
            'user_id' => $juryId,
            'criterion_id' => $request->criterion_id,
            'score' => $request->score,
        ]);

        return response()->json([
            'message' => 'Nilai berhasil disimpan.',
            'data' => $score
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Score $score)
    {
        return response()->json([
            'message' => 'Detail score berhasil diambil.',
            'data' => $score->load([
                'candidate',
                'criterion',
                'jury',
                'period'
            ])
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Score $score)
    {
        $request->validate([
            'score' => 'required|numeric',
        ]);

        $criterion = Criterion::findOrFail(
            $score->criterion_id
        );

        if (
            $request->score < $criterion->min_score ||
            $request->score > $criterion->max_score
        ) {
            return response()->json([
                'message' => 'Nilai berada di luar batas yang diperbolehkan.'
            ], 422);
        }

        $score->update([
            'score' => $request->score
        ]);

        return response()->json([
            'message' => 'Nilai berhasil diperbarui.',
            'data' => $score
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Score $score)
    {
        $score->delete();

        return response()->json([
            'message' => 'Nilai berhasil dihapus.'
        ]);
    }

    /**
     * Menampilkan nilai milik juri yang login.
     */
    public function myScores()
    {
        $scores = Score::with([
            'candidate',
            'criterion',
            'period'
        ])
        ->where('user_id', Auth::id())
        ->get();

        return response()->json([
            'message' => 'Data nilai juri berhasil diambil.',
            'data' => $scores
        ]);
    }
}
