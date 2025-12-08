<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
->middleware('guest');

// Login Route
Route::view('/login', 'login')
->middleware('guest')
->name('login');

Route::post('/login', LoginController::class)
->middleware('guest');

// Dashboard Route
Route::view('/dashboard','dashboard')
// ->middleware(['auth','verified'])
->name('dashboard');

// Logout Route
Route::post('/logout', LogoutController::class)
->middleware('auth')
->name('logout');

// Register new user
Route::post('/register', RegisterController::class)
->middleware('auth:admin')
->name('register');
