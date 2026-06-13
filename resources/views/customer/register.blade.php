<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white flex flex-col min-h-screen justify-between items-center py-6">

    <div class="w-full max-w-md px-6 mt-4">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logo.png') }}" alt="FANTASTIC DIGITAL PRINTING" class="h-20 object-contain" onerror="this.onerror=null; this.outerHTML='<div class=\'text-center border-2 border-red-600 px-6 py-1 bg-red-50 rounded-xl\'><span class=\'text-xl font-black text-red-600 block\'>FANTASTIC</span><span class=\'text-[10px] text-gray-700 tracking-widest font-bold uppercase\'>Digital Printing</span></div>';">
        </div>

        <h2 class="text-center text-xl font-bold text-gray-800 mb-5">Daftar Akun</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-xl mb-4 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner text-gray-700"
                    placeholder="Nama Lengkap">
                <label class="text-[10px] text-gray-700 font-bold block mt-1 pl-2">Masukkan Nama Lengkap Anda</label>
            </div>

            <div>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner text-gray-700"
                    placeholder="08xxxxxxxxxx">
                <label class="text-[10px] text-gray-700 font-bold block mt-1 pl-2">Pastika nomor Handphone Aktif</label>
            </div>

            <div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner text-gray-700"
                    placeholder="username@gmail.com">
                <label class="text-[10px] text-gray-700 font-bold block mt-1 pl-2">Masukan Email untuk Username</label>
            </div>

            <div>
                <input type="password" name="password" required
                    class="w-full bg-red-100/70 border border-transparent rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition shadow-inner text-gray-700"
                    placeholder="••••••••">
                <label class="text-[10px] text-gray-700 font-bold block mt-1 pl-2">Masukkan Password, minimal 6 Karakter kombinasi Huruf dan Angka</label>
            </div>

            <button type="submit" class="w-full bg-red-700 text-white font-bold text-sm py-3 rounded-2xl shadow-md hover:bg-red-800 transition tracking-wide uppercase mt-4">
                DAFTAR AKUN
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-700 font-bold">
                Sudah Punya Akun? <a href="{{ route('login') }}" class="text-red-600 hover:underline">Silahkan Login</a>
            </p>
        </div>
    </div>

    <footer class="w-full text-center text-[11px] text-gray-700 border-t border-red-200 pt-4 mt-6">
        2026 www.fantasticdigitalprinting.com by PrintVibe Project
    </footer>

</body>
</html>