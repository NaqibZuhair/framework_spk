<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ElectionPeriodController;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\CriterionController;
use App\Http\Controllers\Api\JuryCriterionController;
use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\ArasResultController;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/candidates/register', [CandidateController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('periods', ElectionPeriodController::class);

    Route::apiResource('candidates', CandidateController::class)
        ->except(['store']);

    Route::patch('/candidates/{candidate}/validate', [CandidateController::class, 'validateCandidate']);
    Route::patch('/candidates/{candidate}/reject', [CandidateController::class, 'rejectCandidate']);

    Route::apiResource('criteria', CriterionController::class);
    Route::post('criteria/sync', [CriterionController::class, 'sync']);

    Route::get('jury-criteria/options', [JuryCriterionController::class, 'options']);
    Route::post('/jury-criteria/sync', [JuryCriterionController::class, 'sync']);
    Route::apiResource('jury-criteria', JuryCriterionController::class);

    Route::apiResource('interviews', InterviewController::class);

    Route::get('/my-scores', [ScoreController::class, 'myScores']);
    Route::apiResource('scores', ScoreController::class);

    Route::post('/aras-results/calculate', [ArasResultController::class, 'calculate']);
    Route::apiResource('aras-results', ArasResultController::class)
        ->only(['index', 'show', 'destroy']);
});

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\ElectionPeriodController;
// use App\Http\Controllers\Api\CandidateController;
// use App\Http\Controllers\Api\CriterionController;
// use App\Http\Controllers\Api\JuryCriterionController;
// use App\Http\Controllers\Api\InterviewController;
// use App\Http\Controllers\Api\ScoreController;
// use App\Http\Controllers\Api\ArasResultController;

// Route::post('/login', [AuthController::class, 'login']);

// Route::post('/candidates/register', [CandidateController::class, 'store']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);

//     Route::apiResource('/periods', ElectionPeriodController::class);
//     Route::apiResource('/candidates', CandidateController::class)->except(['store']);
//     Route::apiResource('/criteria', CriterionController::class);
//     Route::apiResource('/jury-criteria', JuryCriterionController::class);
//     Route::apiResource('/interviews', InterviewController::class);
//     Route::apiResource('/scores', ScoreController::class);
//     Route::apiResource('/aras-results', ArasResultController::class);
// });

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
