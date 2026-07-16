<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProductController; 
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\AdminPromoController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Customer\PembayaranController;
use App\Http\Controllers\Customer\KeranjangController;


// =========================================================================
// 1. HALAMAN UTAMA & UMUM (Bisa diakses siapa saja, kapan saja)
// =========================================================================

// Menampilkan dashboard utama customer via AuthController
Route::get('/', [AuthController::class, 'index'])->name('customer.dashboard');

// Fitur Katalog Produk & Informasi Toko
Route::get('/semua-produk', [ProductController::class, 'semuaProduk'])->name('customer.semua-produk');
Route::get('/customer/detail-produk/{id}', [ProductController::class, 'detailProduk'])->name('customer.detail-produk');
Route::get('/promo', [ProductController::class, 'halamanPromo'])->name('customer.promo');
Route::get('/jam-layanan', [ProductController::class, 'jamLayanan'])->name('customer.jam-layanan');
Route::view('/tentang', 'customer.tentang-kami')->name('customer.tentang-kami');
Route::match(['get', 'post'], '/pembayaran', [PembayaranController::class, 'prosesPembayaran'])->name('customer.pembayaran');

// =========================================================================
// 2. RUTE AUTENTIKASI (Hanya bisa diakses kalau BELUM LOGIN)
// =========================================================================
Route::middleware('guest')->group(function () {
    // Form Login & Proses Masuk
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Form Daftar Akun & Proses Registrasi
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Fitur Reset Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

// Proses Keluar Akun / Log Out
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 3. RUTE CUSTOMER YANG WAJIB LOGIN (Akses khusus member terdaftar)
// =========================================================================
Route::middleware('auth')->group(function () {
    // --- FITUR DINAMIS DROPDOWN NOTIFIKASI ---
    
    // Halaman pusat semua notifikasi (Tombol 'Lihat Semua')
    Route::get('/notifikasi', [ProductController::class, 'halamanNotifikasi'])->name('customer.notifikasi');
    
    // Halaman riwayat transaksi/pesanan cetak (Tombol 'Pesanan')
    Route::get('/pesanan-saya', [ProductController::class, 'halamanPesanan'])->name('customer.pesanan');
    
    // Halaman informasi update dari sistem/toko (Tombol 'Informasi Terbaru')
    Route::get('/informasi-terbaru', [ProductController::class, 'halamanInformasi'])->name('customer.informasi');


    // --- FITUR DINAMIS KERANJANG BELANJA ---
    
    // Memproses tambah produk ke keranjang belanja
    Route::post('/keranjang/tambah/{productId}', [KeranjangController::class, 'tambah'])->name('customer.keranjang.tambah');
    
    // Memproses hapus item dari daftar keranjang belanja
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('customer.keranjang.hapus');

    // =========================================================================
    // TAMBAHKAN DI SINI (Dalam Middleware Auth):
    // =========================================================================
    Route::post('/pembayaran/simpan', [PembayaranController::class, 'simpanPembayaran'])->name('proses.simpan-pembayaran');

    // Contoh tempat menaruh rute checkout nanti:
    // Route::get('/checkout', [ProductController::class, 'checkout'])->name('customer.checkout');
});


// =========================================================================
// 4. RUTE KHUSUS ADMIN (Wajib Login & Wajib memiliki role Admin)
// =========================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // --- DASHBOARD ADMIN ---
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- MANAJEMEN PRODUK & KATEGORI ---
    Route::resource('produk', AdminProductController::class)->names(['index' => 'produk']);
    
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori/tambah', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/tambah', function () { return view('admin.form-kategori'); })->name('kategori.tambah');
    Route::get('/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');
    
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
    Route::get('/admin/pelanggan', [AdminPelangganController::class, 'index'])->name('pelanggan');
    Route::get('/admin/pelanggan/{id}', [AdminPelangganController::class, 'show'])->name('pelanggan.show');
    Route::get('/admin/pelanggan/detail/{id}', [AdminPelangganController::class, 'show'])->name('pelanggan.detail');

    // --- LAPORAN & PENGATURAN ---
    Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('laporan');
    Route::get('/pengaturan', function () { return view('admin.pengaturan'); })->name('pengaturan');
});