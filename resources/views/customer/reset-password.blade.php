<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru - Fantastic Digital Printing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital@0;1&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-white font-sans min-h-screen flex flex-col">

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-5 w-full">
        <div class="w-full max-w-[680px] p-1">
            
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Fantastic Digital Printing Logo" class="h-28 w-auto object-contain">
            </div>

            <h2 class="text-2xl font-normal text-center text-gray-800 mb-6 tracking-wide">Buat Password Baru</h2>

            {{-- Pesan Error Umum --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-[15px]">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf 
                
                {{-- Hidden Token & Email --}}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Email Input (Disabled/Readonly) --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-gray-700 font-normal pl-1">Email Anda</label>
                    <input type="email" value="{{ $email }}" disabled
                        class="w-full px-5 py-3.5 bg-gray-100 rounded-[15px] text-gray-500 cursor-not-allowed text-base border border-gray-200">
                </div>

                {{-- Password Baru --}}
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm text-gray-700 font-normal pl-1">Password Baru, minimal 6 Karakter kombinasi Huruf dan Angka</label>
                    <input type="password" id="password" name="password" required placeholder="Kombinasi huruf & angka (min. 6 karakter)"
                        @class([
                            'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('password')
                        ])>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation" class="text-sm text-gray-700 font-normal pl-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru"
                        class="w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-base tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                        SIMPAN PASSWORD BARU
                    </button>
                </div>
                
                <div class="text-center text-sm text-gray-600 font-normal pt-1">
                    Batal? Kembali ke halaman <a href="{{ route('login') }}" class="text-[#c40000] hover:underline font-normal">Login</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full text-center text-xs text-gray-700 bg-white font-sans">
        <div class="w-full border-t border-[#f5d5d5] mb-4"></div>
        <p class="pb-4">2026 www.fantasticdigitalprinting.com by PrintVibe Project</p>
    </footer>

</body>
</html>