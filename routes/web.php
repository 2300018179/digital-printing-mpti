<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminProductController; 
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\AdminPromoController;

// =========================================================================
// 1. HALAMAN UTAMA & UMUM (Bisa diakses siapa saja, kapan saja)
// =========================================================================
Route::get('/', [CustomerController::class, 'index'])->name('customer.dashboard');
Route::get('/jam-layanan', [CustomerController::class, 'jamLayanan'])->name('customer.jam-layanan');

// *** INI KUNCINYA *** // Kita taruh rute logout di sini (bebas hambatan), supaya pas session dihancurkan, 
// Laravel tidak kebingungan dan tidak nge-redirect paksa kamu ke halaman login.
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');


// =========================================================================
// 2. RUTE AUTENTIKASI (Hanya bisa diakses kalau BELUM LOGIN)
// =========================================================================
Route::middleware('guest')->group(function () {
    // Form Login & Prosesnya
    Route::get('/login', [CustomerController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerController::class, 'login'])->name('login.submit');

    // Form Daftar Akun & Prosesnya
    Route::get('/register', [CustomerController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerController::class, 'register'])->name('register.submit');

    // Fitur Lupa Password
    Route::get('/forgot-password', [CustomerController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [CustomerController::class, 'sendResetLink'])->name('password.email');
});


// =========================================================================
// 3. RUTE CUSTOMER YANG WAJIB LOGIN (Taruh di sini kalau ada nanti)
// =========================================================================
Route::middleware('auth')->group(function () {
    // Contoh: Route::get('/checkout', [CustomerController::class, 'checkout']);
});


// =========================================================================
// 4. RUTE KHUSUS ADMIN (Wajib Login & Wajib punya role Admin)
// =========================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // --- DASHBOARD ADMIN ---
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- MANAJEMEN PRODUK & KATEGORI ---
    Route::resource('produk', AdminProductController::class)->names(['index' => 'produk']);
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/tambah', function () { return view('admin.form-kategori'); })->name('kategori.tambah');
    Route::post('/kategori/tambah', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    
    // --- MANAJEMEN PESANAN ---
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/detail/{id}', [AdminPesananController::class, 'detail'])->name('pesanan.detail');
    Route::put('/pesanan/update/{id}', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    
    // --- MANAJEMEN PEMBAYARAN ---
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran');
    Route::put('/pembayaran/update/{id}', [AdminPembayaranController::class, 'updateStatus'])->name('pembayaran.update');

    // --- MANAJEMEN PROMO ---
    Route::get('/admin/promo', [AdminPromoController::class, 'index'])->name('promo');
    Route::get('/admin/promo/tambah', function () { return view('admin.tambah-promo'); })->name('promo.tambah');
    Route::post('/admin/promo/store', [AdminPromoController::class, 'store'])->name('promo.store');
    Route::get('/promo/{id}/edit', [AdminPromoController::class, 'edit'])->name('promo.edit');
    Route::put('/promo/{id}', [AdminPromoController::class, 'update'])->name('promo.update');
    Route::delete('/admin/promo/{id}', [AdminPromoController::class, 'destroy'])->name('promo.destroy');

    // --- MANAJEMEN PELANGGAN ---
    Route::get('/pelanggan', function () { return view('admin.pelanggan'); })->name('pelanggan');
    Route::get('/pelanggan/detail/{id}', function ($id) { return view('admin.pelanggan-detail'); })->name('pelanggan.detail');

    // --- LAPORAN & PENGATURAN ---
    Route::get('/laporan', function () { return view('admin.laporan'); })->name('laporan');
    Route::get('/pengaturan', function () { return view('admin.pengaturan'); })->name('pengaturan');
});