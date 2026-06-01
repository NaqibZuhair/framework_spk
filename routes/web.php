<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CriterionController;
use App\Http\Controllers\Api\JuryCriterionController;
use App\Http\Controllers\Api\InterviewController;

Route::get('/', function () {
    return view('public.home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'title' => 'Dashboard Admin - Duta PNJ',
    ]);
})->name('admin.dashboard');

Route::get('/admin/juries/assign-criteria', function () {
    return view('admin.juries.assign-criteria', [
        'title' => 'Assign Kriteria Juri - Duta PNJ',
    ]);
})->name('admin.juries.assign-criteria');

Route::get('/admin/criteria', function () {
    return view('admin.criteria.index', [
        'title' => 'Manajemen Kriteria - Duta PNJ',
    ]);
})->name('admin.criteria.index');

Route::get('/jury/dashboard', function () {
    return view('jury.dashboard');
})->name('jury.dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('criteria', CriterionController::class);
    Route::apiResource('jury-criteria', JuryCriterionController::class);
    Route::post('jury-criteria/sync', [JuryCriterionController::class, 'sync']);
    Route::apiResource('interviews', InterviewController::class);
    Route::post('criteria/sync', [CriterionController::class, 'sync']);
});


