<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Auth Controller
use App\Http\Controllers\AuthController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\Admin\PromoController;

// Controller Customer
use App\Http\Controllers\Customer\DashboardCSController;
use App\Http\Controllers\Customer\ProductsController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\PesananCSController; // <-- 1. IMPORT CONTROLLER BARU

// =========================================================================
// 1. HALAMAN UTAMA & UMUM (Bisa diakses siapa saja)
// =========================================================================

Route::get('/', [DashboardCSController::class, 'index'])->name('customer.dashboard');

Route::get('/semua-produk', [ProductsController::class, 'semuaProduk'])->name('customer.semua-produk');
Route::get('/customer/detail-produk/{id}', [ProductsController::class, 'detailProduk'])->name('customer.detail-produk');
Route::get('/promo', [ProductsController::class, 'halamanPromo'])->name('customer.promo');
Route::get('/jam-layanan', [ProductsController::class, 'jamLayanan'])->name('customer.jam-layanan');

Route::get('/tentang', function () {
    $appSettings = DB::table('settings')->pluck('value', 'key')->toArray();
    return view('customer.tentang-kami', compact('appSettings'));
})->name('customer.tentang-kami');

Route::get('/pembayaran', [PaymentController::class, 'prosesPembayaran'])->name('customer.pembayaran');
Route::post('/pembayaran', [PaymentController::class, 'prosesPembayaran'])->name('customer.pembayaran.process');

// =========================================================================
// 2. RUTE AUTENTIKASI (Hanya jika BELUM LOGIN)
// =========================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/register/verify-otp', [AuthController::class, 'verifyOtp'])->name('register.verify');
    Route::get('/register/cancel-otp', [AuthController::class, 'cancelOtp'])->name('register.cancel');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 3. RUTE CUSTOMER (Wajib Login Member)
// =========================================================================

Route::middleware('auth')->group(function () {
    Route::get('/notifikasi', [ProductsController::class, 'halamanNotifikasi'])->name('customer.notifikasi');
    Route::post('/notifikasi/mark-all-read', [ProductsController::class, 'markAllRead'])->name('customer.notifikasi.markAllRead');
    
    // 2. DIUBAH UNTUK MENGGUNAKAN PesananCSController
    Route::get('/pesanan-saya', [PesananCSController::class, 'index'])->name('customer.pesanan-saya');
    Route::get('/pesanan', [PesananCSController::class, 'index'])->name('customer.pesanan');
    
    // === TAMBAHKAN ROUTE INI DI SINI ===
    Route::get('/pesanan/download-desain/{filename}', [PesananCSController::class, 'downloadDesain'])->name('customer.download-desain');

    Route::get('/informasi-terbaru', [ProductsController::class, 'halamanInformasi'])->name('customer.informasi');

    Route::post('/keranjang/tambah/{productId}', [KeranjangController::class, 'tambah'])->name('customer.keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('customer.keranjang.hapus');

    Route::post('/pembayaran/simpan', [PaymentController::class, 'simpanPembayaran'])->name('customer.pembayaran.simpan');
});

// =========================================================================
// 4. RUTE ADMIN (Wajib Login & Role Admin)
// =========================================================================

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', ProductController::class)->names(['index' => 'produk']);
    
    // Kategori & Sub-Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::view('/kategori/tambah', 'admin.form-kategori')->name('kategori.tambah');
    Route::post('/kategori/tambah', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/subkategori/{id}/edit', [KategoriController::class, 'editSubKategori'])->name('subkategori.edit');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    
    // Pesanan & Pembayaran
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/detail/{id}', [PesananController::class, 'detail'])->name('pesanan.detail');
    Route::put('/pesanan/update/{id}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/pesanan/download-desain/{id}', [PesananController::class, 'downloadDesain'])->name('pesanan.downloadDesain');
    
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');

    // Promo Actions
    Route::get('/promo', [PromoController::class, 'index'])->name('promo');
    Route::view('/promo/tambah', 'admin.tambah-promo')->name('promo.tambah');
    Route::post('/promo/store', [PromoController::class, 'store'])->name('promo.store');
    Route::get('/promo/{id}/edit', [PromoController::class, 'edit'])->name('promo.edit');
    Route::put('/promo/{id}', [PromoController::class, 'update'])->name('promo.update');
    Route::delete('/promo/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');

    // Pengumuman Actions
    Route::view('/pengumuman/tambah', 'admin.tambah-pengumuman')->name('pengumuman.tambah');
    Route::post('/pengumuman/store', [PromoController::class, 'storePengumuman'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}/edit', [PromoController::class, 'editPengumuman'])->name('pengumuman.edit');
    Route::put('/pengumuman/{id}', [PromoController::class, 'updatePengumuman'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PromoController::class, 'destroyPengumuman'])->name('pengumuman.destroy');

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
    Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');

    // Pengaturan & Laporan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
    // Pengaturan & Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
    Route::get('/laporan/cetak-excel', [LaporanController::class, 'cetakExcel'])->name('laporan.excel');
});