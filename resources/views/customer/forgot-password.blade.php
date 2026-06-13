<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white flex flex-col min-h-screen justify-between items-center py-6">

    <div class="w-full max-w-md px-6 mt-12">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logo.png') }}" alt="FANTASTIC DIGITAL PRINTING" class="h-24 object-contain" onerror="this.onerror=null; this.outerHTML='<div class=\'text-center border-2 border-red-600 px-6 py-2 bg-red-50 rounded-xl\'><span class=\'text-2xl font-black text-red-600 block\'>FANTASTIC</span><span class=\'text-xs text-gray-700 tracking-widest font-bold uppercase\'>Digital Printing</span></div>';">
        </div>

        <h2 class="text-center text-xl font-bold text-gray-800 mb-6">Reset Password</h2>

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

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner text-gray-700"
                    placeholder="Masukkan Email Anda">
                <label class="text-[11px] text-gray-600 font-medium block mt-2 text-center leading-tight">
                    Masukkan Email yang didaftarkan sebagai username untuk reset password
                </label>
            </div>

            <button type="submit" class="w-full bg-red-700 text-white font-bold text-sm py-3 rounded-2xl shadow-md hover:bg-red-800 transition tracking-wide uppercase mt-4">
                KIRIM
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs text-gray-600 font-bold">
                Kembali Ke halaman <a href="{{ route('login') }}" class="text-red-600 hover:underline">Login</a> atau <a href="{{ route('register') }}" class="text-red-600 hover:underline">Daftar</a>
            </p>
        </div>
    </div>

    <footer class="w-full text-center text-[11px] text-gray-700 border-t border-red-200 pt-4 mt-12">
        2026 www.fantasticdigitalprinting.com by PrintVibe Project
    </footer>

</body>
</html>