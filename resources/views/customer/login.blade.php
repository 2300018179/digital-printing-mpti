<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white-50 flex flex-col min-h-screen justify-between items-center py-6">

    <!-- Kontainer Tengah Form -->
    <div class="w-full max-w-md px-6 mt-8">
        <!-- Logo Atas (Menggunakan file public/img/logo.png yang sudah kamu buat sebelumnya) -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logo.png') }}" alt="FANTASTIC DIGITAL PRINTING" class="h-24 object-contain" onerror="this.onerror=null; this.outerHTML='<div class=\'text-center border-2 border-red-600 px-6 py-2 bg-red-50 rounded-xl\'><span class=\'text-2xl font-black text-red-600 block\'>FANTASTIC</span><span class=\'text-xs text-gray-700 tracking-widest font-bold uppercase\'>Digital Printing</span></div>';">
        </div>

        <h2 class="text-center text-xl font-bold text-gray-800 mb-6">Log In</h2>

        <!-- Tampilan Notifikasi Merah Jika Email/Password Salah -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2.5 rounded-xl mb-4 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2.5 rounded-xl mb-4 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Aksi Nyata -->
        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf <!-- Token Keamanan Wajib Laravel -->

            <!-- Input Email -->
            <div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner placeholder-gray-400 text-gray-700"
                    placeholder="Contoh: user@gmail.com">
                <label class="text-[11px] text-gray-700 font-bold block mt-1 pl-2">Masukkan Email / Username</label>
            </div>

            <!-- Input Password -->
            <div>
                <input type="password" name="password" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner placeholder-gray-400 text-gray-700"
                    placeholder="••••••••">
                <label class="text-[11px] text-gray-700 font-bold block mt-1 pl-2">Masukkan Password</label>
            </div>

            <!-- Fitur Ingat Saya & Lupa Password -->
            <div class="flex justify-between items-center text-[10px] px-1 font-semibold">
                <label class="flex items-center text-gray-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="mr-1.5 rounded accent-red-600"> Ingat Saya
                </label>
                <a href="{{ route('password.request') }}" class="text-red-600 hover:underline">Lupa Password?</a>
            </div>

            <!-- Tombol LOGIN Utama -->
            <button type="submit" class="w-full bg-red-700 text-white font-bold text-sm py-3 rounded-2xl shadow-md hover:bg-red-800 transition tracking-wide uppercase mt-2">
                LOGIN
            </button>
        </form>

        <!-- Seksi Belum Punya Akun & Daftar -->
        <div class="text-center mt-4 space-y-3">
            <p class="text-xs text-gray-600 font-bold">Belum Punya Akun?</p>
            <a href="{{ route('register') }}" class="w-full block bg-red-700 text-white font-bold text-sm py-3 rounded-2xl shadow-md hover:bg-red-800 transition tracking-wide uppercase text-center">
                DAFTAR
            </a>
        </div>
    </div>

    <!-- Catatan Kaki (Footer) Sesuai Gambar -->
    <footer class="w-full text-center text-[11px] text-gray-700 border-t border-red-200 pt-4 mt-8">
        2026 www.fantasticdigitalprinting.com by PrintVibe Project
    </footer>

</body>
</html>