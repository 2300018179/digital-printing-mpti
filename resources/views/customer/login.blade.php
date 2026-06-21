<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fantastic Digital Printing</title>
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

            <h2 class="text-2xl font-normal text-center text-gray-800 mb-8 tracking-wide">Log In</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-[15px] text-sm text-center font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf 
                
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm text-gray-700 font-normal pl-1">
                        Masukkan Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        @class([
                            'w-full px-5 py-4 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base',
                            'border border-red-500 focus:ring-red-500/20' => $errors->has('email')
                        ])>
                    
                    @error('email')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm text-gray-700 font-normal pl-1">
                        Masukkan Password
                    </label>
                    <div class="relative w-full">
                        <input type="password" id="password" name="password" required
                            @class([
                                'w-full px-5 py-4 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base pr-14',
                                'border border-red-500 focus:ring-red-500/20' => $errors->has('password')
                            ])>
                        
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <svg id="eyeOpenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg id="eyeCloseIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                    
                    @error('password')
                        <span class="text-xs text-red-500 pl-1" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs text-gray-500 px-1 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-gray-600">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#c40000] focus:ring-[#c40000]">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[#c40000] hover:underline font-normal">Lupa Password?</a>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-base tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                        LOG IN
                    </button>
                </div>
                
                <div class="text-center text-sm text-gray-500 font-normal py-1">
                    Belum Punya Akun?
                </div>
                
                <div>
                    <a href="{{ route('register') }}" 
                        class="block w-full text-center bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-base tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                        REGISTRATION
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full text-center text-xs text-gray-700 bg-white font-sans">
        <div class="w-full border-t border-[#f5d5d5] mb-4"></div>
        <p class="pb-4">2026 www.fantasticdigitalprinting.com by PrintVibe Project</p>
    </footer>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            const eyeCloseIcon = document.getElementById('eyeCloseIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpenIcon.classList.add('hidden');
                eyeCloseIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpenIcon.classList.remove('hidden');
                eyeCloseIcon.classList.add('hidden');
            }
        }
    </script>

</body>
</html>