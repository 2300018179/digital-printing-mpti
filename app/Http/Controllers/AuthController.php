<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 

class AuthController extends Controller
{
    // Menampilkan halaman Dashboard utama
    // Menampilkan halaman Dashboard utama
    public function index()
    {
        // 1. Ambil kategori untuk menu sidebar
        $categories = DB::table('kategoris')->get();

        // 2. Ambil produk unggulan
        $products = \App\Models\Product::where('status', '1')
                    ->withSum('detailPesanan', 'jumlah')
                    ->get()
                    ->sortByDesc('detail_pesanan_sum_jumlah')
                    ->take(5);

        // 3. Ambil settings dari database
        $appSettings = DB::table('settings')->pluck('value', 'key')->toArray();

        // 4. Kirim sebagai $appSettings agar sesuai dengan kode Blade kamu
        return view('customer.dashboard', compact('categories', 'products', 'appSettings'));
    }

    // Menampilkan halaman Login form
    public function showLogin()
    {
        return view('customer.login');
    }

    // Memproses data input dari Form Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    // Memproses Log Out / Keluar Akun
    public function logout(Request $request)
    {
        $isAdmin = Auth::user() && Auth::user()->role === 'admin';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect()->route('login'); 
        }

        return redirect()->route('customer.dashboard'); 
    }

    // Menampilkan halaman Daftar Akun
    public function showRegister()
    {
        return view('customer.register');
    }

    // Kode otp
    public function register(Request $request)
    {
        if (session()->has('otp_requested') && session()->has('otp_expires_at')) {
            $remainingCooldown = now()->diffInSeconds(session('otp_cooldown_until', now()), false);
            
            if ($remainingCooldown > 0) {
                return redirect()->back()->with('error', 'Silakan tunggu ' . ceil($remainingCooldown / 60) . ' menit lagi untuk meminta OTP kembali.');
            }
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'string', 'max:20', 'unique:users,phone'], 
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'], 
        ], [
            'phone.unique' => 'Nomor Handphone ini sudah terdaftar, silakan gunakan nomor lain.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $otpCode = rand(100000, 999999);

        session([
            'registration_data' => [
                'name'     => $request->name,
                'phone'    => $request->phone, 
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ],
            'otp_code'           => $otpCode,
            'otp_requested'      => true, 
            'otp_expires_at'     => now()->addMinutes(5), 
            'otp_cooldown_until' => now()->addMinutes(2)  
        ]);

        $htmlContent = "
            <div style='font-family: sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                <h2 style='color: #c40000; text-align: center;'>Fantastic Digital Printing</h2>
                <p>Halo <strong>{$request->name}</strong>,</p>
                <p>Berikut adalah kode OTP untuk memverifikasi pendaftaran akun Anda:</p>
                <div style='text-align: center; margin: 20px 0;'>
                    <span style='font-size: 32px; font-weight: bold; color: #c40000; background: #f5d5d5; padding: 10px 20px; border-radius: 8px; display: inline-block; letter-spacing: 5px;'>
                        {$otpCode}
                    </span>
                </div>
                <p style='font-size: 12px; color: #777;'>Kode ini berlaku selama 5 menit. Jangan bagikan kode ini kepada siapa pun.</p>
            </div>
        ";

        Mail::html($htmlContent, function($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode Verifikasi OTP - Fantastic Digital Printing');
        });

        return redirect()->route('register');
    }

    // Memproses verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        if (!session()->has('registration_data')) {
            return redirect()->route('register')->with('error', 'Sesi pendaftaran berakhir, silakan isi kembali form.');
        }

        if (now()->gt(session('otp_expires_at'))) {
            return redirect()->route('register')->with('error', 'Kode OTP telah kedaluwarsa. Silakan registrasi ulang.');
        }

        if ($request->otp == session('otp_code')) {
            $data = session('registration_data');
            
            $user = \App\Models\User::create([
                'name'     => $data['name'],
                'phone'    => $data['phone'], 
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'customer', 
            ]);

            session()->forget([
                'registration_data', 
                'otp_code', 
                'otp_requested', 
                'otp_expires_at', 
                'otp_cooldown_until'
            ]);

            Auth::login($user);

            return redirect()->route('customer.dashboard')->with('success', 'Akun berhasil diverifikasi!');
        }

        return redirect()->back()->with('error', 'Kode OTP yang Anda masukkan salah.')->withInput();
    }

    // Batalkan OTP & kembali ke form
    public function cancelOtp()
    {
        session()->forget([
            'registration_data', 
            'otp_code', 
            'otp_requested', 
            'otp_expires_at', 
            'otp_cooldown_until'
        ]);
        
        return redirect()->route('register');
    }

    // Menampilkan halaman Lupa Password (Reset Password)
    public function showForgotPassword()
    {
        return view('customer.forgot-password');
    }

    // Memproses simulasi klik tombol KIRIM
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        return back()->with('status', 'Link reset password berhasil dikirim ke email Anda!');
    }
}