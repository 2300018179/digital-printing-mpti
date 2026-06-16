<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminProductController; // << 1. BERHASIL DI-IMPORT DI SINI

// 1. Halaman Utama & Umum
Route::get('/', [CustomerController::class, 'index'])->name('customer.dashboard');
Route::get('/jam-layanan', [CustomerController::class, 'jamLayanan'])->name('customer.jam-layanan');

// 2. RUTE AUTENTIKASI (LOGIN & REGISTER)
Route::middleware('guest')->group(function () {
    // Form Login
    Route::get('/login', [CustomerController::class, 'showLogin'])->name('login');
    // Proses Kirim Data Login (POST)
    Route::post('/login', [CustomerController::class, 'login'])->name('login.submit');

    // Form Daftar Akun
    Route::get('/register', [CustomerController::class, 'showRegister'])->name('register');
    // Proses Kirim Data Daftar (POST)
    Route::post('/register', [CustomerController::class, 'register'])->name('register.submit');

    // --- RUTE LUPA PASSWORD ---
    // Form Lupa Password
    Route::get('/forgot-password', [CustomerController::class, 'showForgotPassword'])->name('password.request');
    // Proses Kirim Link Reset ke Email (POST)
    Route::post('/forgot-password', [CustomerController::class, 'sendResetLink'])->name('password.email');
});

// Proses Keluar Akun (Log Out) - Hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
});

// 3. RUTE ADMIN (BAWAAN UPDATE)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- MANAJEMEN PRODUK (CRUD RESOURCE) ---
    // PERBAIKAN: Rute closure statis /produk, /produk/tambah, dan /produk/edit dihapus 
    // karena sudah ditangani secara otomatis dan jauh lebih aman oleh Route::resource di bawah ini.
    Route::resource('produk', AdminProductController::class)->names([
        'index' => 'produk',
    ]);

    // --- MANAJEMEN KATEGORI ---
    Route::get('/kategori', function () {
        return view('admin.kategori');
    })->name('kategori');

    Route::get('/kategori/tambah', function () {
        return view('admin.form-kategori');
    })->name('kategori.tambah');

    // --- MANAJEMEN PESANAN ---
    Route::get('/pesanan', function () {
        return view('admin.pesanan');
    })->name('pesanan');

    Route::get('/pesanan/detail', function () {
        return view('admin.detail-pesanan');
    })->name('pesanan.detail');

    // --- MANAJEMEN PEMBAYARAN ---
    Route::get('/pembayaran', function () {
        return view('admin.pembayaran');
    })->name('pembayaran');

    // --- MANAJEMEN PROMO ---
    Route::get('/promo', function () {
        return view('admin.promo');
    })->name('promo');

    Route::get('/promo/tambah', function () {
        return view('admin.tambah-promo'); 
    })->name('promo.tambah');

    // --- MANAJEMEN PELANGGAN ---
    Route::get('/pelanggan', function () {
        return view('admin.pelanggan');
    })->name('pelanggan');

    Route::get('/pelanggan/detail/{id}', function ($id) {
        return view('admin.pelanggan-detail');
    })->name('pelanggan.detail');

    // --- LAPORAN & PENGATURAN ---
    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');

    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('pengaturan');
    
});