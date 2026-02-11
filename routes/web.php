<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Http\Controllers\IndexController::class)->name('index');
Route::get('/login', App\Http\Controllers\auth\IndexController::class)->name('auth.login');
