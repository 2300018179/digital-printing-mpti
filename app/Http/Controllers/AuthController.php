<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            if ($remember) {

                Cookie::queue('remembered_email', $request->email, 43200);
            } else {

                Cookie::queue(Cookie::forget('remembered_email'));
            }

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

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

    public function showRegister()
    {
        return view('customer.register');
    }

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
            'password' => ['required', 'string', 'min:6', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ], [
            'phone.unique' => 'Nomor Handphone ini sudah terdaftar, silakan gunakan nomor lain.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.regex' => 'Password harus mengandung kombinasi huruf dan angka.',
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

        try {
            Mail::html($htmlContent, function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode Verifikasi OTP - Fantastic Digital Printing');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim email OTP. Pastikan koneksi dan email Anda benar.');
        }

        return redirect()->route('register');
    }

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
            
            $user = DB::transaction(function () use ($data) {
                return User::create([
                    'name'     => $data['name'],
                    'phone'    => $data['phone'], 
                    'email'    => $data['email'],
                    'password' => $data['password'],
                    'role'     => 'customer', 
                ]);
            });

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

    public function showForgotPassword()
    {
        return view('customer.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => $token,
                'created_at' => now()
            ]
        );

        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        $htmlContent = "
            <div style='font-family: sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                <h2 style='color: #c40000; text-align: center;'>Fantastic Digital Printing</h2>
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah untuk melanjutkan:</p>
                <div style='text-align: center; margin: 25px 0;'>
                    <a href='{$resetLink}' style='background-color: #c40000; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Reset Password</a>
                </div>
                <p style='font-size: 12px; color: #777;'>Jika Anda tidak meminta reset password, abaikan saja email ini.</p>
            </div>
        ";

        try {
            Mail::html($htmlContent, function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Instruksi Reset Password - Fantastic Digital Printing');
            });

            return back()->with('status', 'Link reset password berhasil dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email reset password. Coba lagi nanti.']);
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('customer.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => ['required', 'string', 'min:6', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/', 'confirmed'],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal harus 6 karakter.',
            'password.regex'     => 'Password harus mengandung kombinasi huruf dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluwarsa.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}