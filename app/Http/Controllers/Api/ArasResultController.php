<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArasResult;
use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArasResultController extends Controller
{
    /**
     * Menampilkan semua hasil ranking.
     */
    public function index()
    {
        $results = ArasResult::with([
            'candidate',
            'period',
            'calculator'
        ])
        ->orderBy('final_rank')
        ->get();

        return response()->json([
            'message' => 'Data hasil ARAS berhasil diambil.',
            'data' => $results
        ]);
    }

    /**
     * Menampilkan detail hasil ranking.
     */
    public function show(ArasResult $arasResult)
    {
        return response()->json([
            'message' => 'Detail hasil ARAS.',
            'data' => $arasResult->load([
                'candidate',
                'period',
                'calculator'
            ])
        ]);
    }

    /**
     * Menghapus hasil ranking.
     */
    public function destroy(ArasResult $arasResult)
    {
        $arasResult->delete();

        return response()->json([
            'message' => 'Data hasil ARAS berhasil dihapus.'
        ]);
    }

    /**
     * Menghitung hasil ARAS.
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:election_periods,id'
        ]);

        $periodId = $request->period_id;

        $candidates = Candidate::where(
            'period_id',
            $periodId
        )->get();

        $criteria = Criterion::where(
            'period_id',
            $periodId
        )
        ->where('is_active', true)
        ->get();

        if ($candidates->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada kandidat pada periode ini.'
            ], 422);
        }

        if ($criteria->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada kriteria aktif pada periode ini.'
            ], 422);
        }

        $matrix = [];

        foreach ($candidates as $candidate) {

            foreach ($criteria as $criterion) {

                $average = Score::where(
                    'candidate_id',
                    $candidate->id
                )
                ->where(
                    'criterion_id',
                    $criterion->id
                )
                ->avg('score');

                $matrix[$candidate->id][$criterion->id]
                    = $average ?? 0;
            }
        }

        $results = [];

        foreach ($candidates as $candidate) {

            $totalScore = 0;

            foreach ($criteria as $criterion) {

                $value =
                    $matrix[$candidate->id][$criterion->id];

                $totalScore +=
                    $value *
                    $criterion->weight;
            }

            $results[] = [
                'candidate_id' => $candidate->id,
                'total_score' => $totalScore
            ];
        }

        usort(
            $results,
            fn ($a, $b)
                => $b['total_score']
                <=> $a['total_score']
        );

        ArasResult::where(
            'period_id',
            $periodId
        )->delete();

        foreach ($results as $index => $result) {

            ArasResult::create([
                'period_id' => $periodId,
                'candidate_id' => $result['candidate_id'],
                'total_score' => $result['total_score'],
                'utility_score' => $result['total_score'],
                'final_rank' => $index + 1,
                'calculated_by' => Auth::id(),
                'calculated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Perhitungan ARAS berhasil dilakukan.'
        ]);
    }
}
