<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan halaman Dashboard utama
    public function index()
    {
        // 1. Ambil data kategori untuk sidebar
        $categories = \Illuminate\Support\Facades\DB::table('kategoris')->get();

        // 2. Ambil 5 produk unggulan (Terlaris/Terbanyak Dilihat)
        // Ganti 'total_sold' dengan kolom yang sesuai di databasemu (misal: 'id' atau 'created_at' jika belum ada)
        $products = \App\Models\Product::where('status', '1')
                        ->orderBy('total_sold', 'desc') 
                        ->take(5)
                        ->get(); 

        // 3. Kirimkan variabel ke view dashboard
        return view('customer.dashboard', compact('categories', 'products'));
    }

    // Menampilkan halaman Login form
    public function showLogin()
    {
        return view('customer.login');
    }

    // Memproses data input dari Form Login
    public function login(Request $request)
    {
        // 1. Validasi inputan form terlebih dahulu
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // 2. Coba cocokkan data dengan database menggunakan fungsi bawaan Auth Laravel
        if (Auth::attempt($credentials, $remember)) {
            // Jika sukses, buat ulang session token keamanan
            $request->session()->regenerate();
            
            // --- LOGIKA PENGALIHAN BERDASARKAN ROLE ---
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Lempar ke dashboard admin kamu
            }

            // Jika bukan admin (berarti customer), lempar ke dashboard customer bawaan
            return redirect()->route('customer.dashboard');
        }

        // 3. Jika gagal/salah, kembalikan ke login dengan pesan error merah
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    // Fungsi untuk memproses Log Out / Keluar Akun
    public function logout(Request $request)
    {
        // Ambil data status role sebelum session-nya dihapus
        $isAdmin = Auth::user() && Auth::user()->role === 'admin';

        // Proses logout dari sistem autentikasi Laravel
        Auth::logout();

        // Hancurkan session dan buat ulang token CSRF demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Pengalihan cerdas berdasarkan role yang keluar
        if ($isAdmin) {
            return redirect()->route('login'); // Admin dilempar ke form login
        }

        return redirect()->route('customer.dashboard'); // Customer tetap di dashboard sebagai Guest
    }

    // Menampilkan halaman Daftar Akun
    public function showRegister()
    {
        return view('customer.register');
    }

    // Memproses penyimpanan data pendaftaran pengguna baru
    public function register(Request $request)
    {
        // 1. Validasi inputan form (Sudah ditambahkan unique untuk phone)
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'string', 'max:20', 'unique:users,phone'], // <-- DIGANTI DI SINI
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'], 
        ], [
            'phone.unique' => 'Nomor Handphone ini sudah terdaftar, silakan gunakan nomor lain.', // <-- DITAMBAHKAN
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        // 2. Buat data user baru ke database dengan role 'customer'
        \App\Models\User::create([
            'name'     => $request->name,
            'phone'    => $request->phone, 
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer', 
        ]);

        // 3. Setelah sukses mendaftar, otomatis lempar ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Menampilkan halaman Lupa Password (Reset Password)
    public function showForgotPassword()
    {
        return view('customer.forgot-password');
    }

    // Memproses simulasi klik tombol KIRIM (Hanya aksi visual)
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        return back()->with('status', 'Link reset password berhasil dikirim ke email Anda!');
    }
}