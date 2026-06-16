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
<body class="bg-white font-sans min-h-screen flex flex-col justify-between">

    <div class="flex-1 flex flex-col items-center justify-center px-4 py-6 w-full">
        
        <div class="w-full max-w-[680px] p-4">
            
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Fantastic Digital Printing Logo" class="h-28 w-auto object-contain">
            </div>

            <h2 class="text-2xl font-normal text-center text-gray-800 mb-8 tracking-wide">Log In</h2>

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf 
                
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm text-gray-700 font-normal pl-1">
                        Masukkan Email
                    </label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-5 py-4 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm text-gray-700 font-normal pl-1">
                        Masukkan Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-5 py-4 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base">
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
    </div>

    <div class="w-full border-t border-[#f5d5d5]"></div>

    <footer class="w-full text-center py-4 text-xs text-gray-700 bg-white font-sans">
        2026 www.fantasticdigitalprinting.com by PrintVibe Project
    </footer>

</body>
</html>