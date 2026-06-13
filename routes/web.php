<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController; // <-- BARIS INI WAJIB ADA!

// Halaman utama welcome
Route::get('/', function () {
    return view('welcome');
});

// Jalur pencarian halaman Dashboard Pelanggan
Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

// Otomatis arahkan halaman awal utama ke Form Login
Route::get('/', [CustomerController::class, 'showLogin'])->name('login');

// Proses pengiriman data form login (POST)
Route::post('/login', [CustomerController::class, 'login'])->name('login.submit');

// Halaman dashboard utama setelah sukses login
Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

// Proses keluar akun (Log Out)
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

// Halaman Form Daftar Akun
Route::get('/register', [CustomerController::class, 'showRegister'])->name('register');

// Memproses kiriman data Form Daftar (POST)
Route::post('/register', [CustomerController::class, 'register'])->name('register.submit');

// Halaman Tampilan Lupa Password
Route::get('/forgot-password', [CustomerController::class, 'showForgotPassword'])->name('password.request');

// Proses Kirim Link ke Email (POST)
Route::post('/forgot-password', [CustomerController::class, 'sendResetLink'])->name('password.email');