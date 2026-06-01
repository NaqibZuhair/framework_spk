<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/jury/dashboard', function () {
    return view('jury.dashboard');
})->name('jury.dashboard');
