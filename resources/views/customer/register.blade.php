<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Fantastic Digital Printing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital@0;1&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-white font-sans min-h-screen flex flex-col justify-between">

    <div class="flex-1 flex flex-col items-center justify-center px-4 py-6 w-full">
        
        <div class="w-full max-w-[680px] p-4">
            
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Fantastic Digital Printing Logo" class="h-28 w-auto object-contain">
            </div>

            <h2 class="text-2xl font-normal text-center text-gray-800 mb-6 tracking-wide">Daftar Akun</h2>

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf 
                
                <div class="flex flex-col gap-1.5">
                    <input type="text" id="name" name="name" required
                        class="w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                    <label for="name" class="text-xs text-gray-700 font-normal pl-1">
                        Masukkan Nama Lengkap Anda
                    </label>
                </div>

                <div class="flex flex-col gap-1.5">
                    <input type="tel" id="phone" name="phone" required
                        class="w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                    <label for="phone" class="text-xs text-gray-700 font-normal pl-1">
                        Pastikan nomor Handphone Aktif
                    </label>
                </div>

                <div class="flex flex-col gap-1.5">
                    <input type="email" id="email" name="email" required
                        class="w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                    <label for="email" class="text-xs text-gray-700 font-normal pl-1">
                        Masukan Email untuk Username
                    </label>
                </div>

                <div class="flex flex-col gap-1.5">
                    <input type="password" id="password" name="password" required
                        class="w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                    <label for="password" class="text-xs text-gray-700 font-normal pl-1">
                        Masukkan Password, minimal 6 Karakter kombinasi Huruf dan Angka
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-base tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                        DAFTAR AKUN
                    </button>
                </div>
                
                <div class="text-center text-sm text-gray-800 font-normal pt-1">
                    Sudah Punya Akun? <a href="{{ route('login') }}" class="text-[#c40000] hover:underline font-medium">Silahkan Login</a>
                </div>
            </form>
        </div>
    </div>

    <div class="w-full border-t border-[#f5d5d5]"></div>

    <footer class="w-full text-center py-4 text-xs text-gray-700 bg-white font-sans">
        2026 www.fantasticdigitalprinting.com by PrintVibe Project
    </footer>

</body>
</html>