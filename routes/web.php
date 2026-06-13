<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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
// Halaman Utama Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Halaman Manajemen Data Produk Admin
Route::get('/admin/produk', function () {
    return view('admin.produk');
})->name('admin.produk');

// Halaman Tambah Produk
Route::get('/admin/produk/tambah', function () {
    return view('admin.form-produk', ['mode' => 'tambah']);
})->name('admin.produk.tambah');

Route::get('/kategori', function () {
    return view('admin.kategori');
})->name('admin.kategori');

// Letakkan di dalam grup admin bersama rute kategori lainnya
Route::get('/kategori/tambah', function () {
    return view('admin.form-kategori');
})->name('admin.kategori.tambah');

// Halaman Edit Produk (Simulasi Data Statis untuk dicoba dulu)
Route::get('/admin/produk/edit', function () {
    $produkDummy = [
        'nama' => 'Kartu Nama',
        'kategori' => 'Kartu Nama',
        'harga' => 50000,
        'stok' => 120,
        'deskripsi' => 'Cetak kartu nama bisnis premium dua sisi bahan Art Carton 260gr.',
        'status' => 'Aktif'
    ];
    return view('admin.form-produk', ['mode' => 'edit', 'produk' => $produkDummy]);
})->name('admin.produk.edit');