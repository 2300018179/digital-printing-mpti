<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Fantastic Digital Printing</title>
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

            <h2 class="text-2xl font-normal text-center text-gray-800 mb-6 tracking-wide">Registration</h2>

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-3">
                @csrf 
                
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-xs text-gray-700 font-normal pl-1">
                        Masukkan Nama Lengkap Anda
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        @class([
                            'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('name')
                        ])>

                    @error('name')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="phone" class="text-xs text-gray-700 font-normal pl-1">
                        Pastikan nomor Handphone Aktif
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        @class([
                            'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('phone')
                        ])>

                    @error('phone')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-xs text-gray-700 font-normal pl-1">
                        Masukan Email untuk Username
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        @class([
                            'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('email')
                        ])>

                    @error('email')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-xs text-gray-700 font-normal pl-1">
                        Masukkan Password, minimal 6 Karakter kombinasi Huruf dan Angka
                    </label>
                    <input type="password" id="password" name="password" required
                        @class([
                            'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('password')
                        ])>

                    @error('password')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-base tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                        REGISTRATION
                    </button>
                </div>
                
                <div class="text-center text-sm text-gray-800 font-normal pt-1">
                    Sudah Punya Akun? <a href="{{ route('login') }}" class="text-[#c40000] hover:underline font-normal">Silahkan Login</a>
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