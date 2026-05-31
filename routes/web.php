<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/dashboard', function () {
    return 'Dashboard Admin';
})->name('admin.dashboard');

Route::get('/jury/dashboard', function () {
    return 'Dashboard Juri';
})->name('jury.dashboard');
