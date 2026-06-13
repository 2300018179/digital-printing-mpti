<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

// 1. Halaman Utama
Route::get('/', [CustomerController::class, 'index'])->name('customer.dashboard');

Route::get('/jam-layanan', [CustomerController::class, 'jamLayanan'])->name('customer.jam-layanan');

// --- RUTE AUTENTIKASI (LOGIN & REGISTER) ---

// Form Login
Route::get('/login', [CustomerController::class, 'showLogin'])->name('login');
// Proses Kirim Data Login (POST)
Route::post('/login', [CustomerController::class, 'login'])->name('login.submit');
// Proses Keluar Akun (Log Out)
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

// Form Daftar Akun
Route::get('/register', [CustomerController::class, 'showRegister'])->name('register');
// Proses Kirim Data Daftar (POST)
Route::post('/register', [CustomerController::class, 'register'])->name('register.submit');


// --- RUTE LUPA PASSWORD ---

// Form Lupa Password
Route::get('/forgot-password', [CustomerController::class, 'showForgotPassword'])->name('password.request');
// Proses Kirim Link Reset ke Email (POST)
Route::post('/forgot-password', [CustomerController::class, 'sendResetLink'])->name('password.email');