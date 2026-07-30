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
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body x-data="{ openOtp: {{ session()->has('otp_requested') ? 'true' : 'false' }} }" class="bg-white font-sans min-h-screen flex flex-col relative">
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-5 w-full">
        <div class="w-full max-w-[680px] p-1">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Fantastic Digital Printing Logo" class="h-28 w-auto object-contain">
            </div>
            <h2 class="text-2xl font-normal text-center text-gray-800 mb-6 tracking-wide">Registration</h2>
            
            <form action="{{ route('register.submit') }}" method="POST" class="space-y-3">
                @csrf 
                
                <!-- Input Nama -->
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

                <!-- Input No HP -->
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

                <!-- Input Email -->
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

                <!-- Input Password dengan Toggle Intip Password Alpine.js -->
                <div class="flex flex-col gap-1.5" x-data="{ showPass: false }">
                    <label for="password" class="text-xs text-gray-700 font-normal pl-1">
                        Masukkan Password, minimal 6 Karakter kombinasi Huruf dan Angka
                    </label>
                    <div class="relative w-full">
                        <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                            @class([
                                'w-full px-5 py-3.5 bg-[#f5d5d5] rounded-[15px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]/20 transition-all text-base pr-14',
                                'border border-red-500 focus:ring-red-500/20' => $errors->has('password')
                            ])>
                        <button type="button" @click="showPass = !showPass" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="showPass" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
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

    @php
        $cooldownSeconds = session()->has('otp_cooldown_until') ? max(0, now()->diffInSeconds(session('otp_cooldown_until'), false)) : 0;
    @endphp

    <!-- Modal Verifikasi OTP -->
    <div x-show="openOtp" 
        x-cloak
        x-data="{ 
            timer: {{ $cooldownSeconds }},
            init() {
                if(this.timer > 0) {
                    let countdown = setInterval(() => {
                        this.timer--;
                        if(this.timer <= 0) clearInterval(countdown);
                    }, 1000);
                }
                // Auto focus ke kotak pertama saat modal terbuka
                this.$nextTick(() => {
                    let firstInput = document.getElementById('otp-0');
                    if (firstInput) firstInput.focus();
                });
            }
        }"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        
        <div class="bg-white w-full max-w-[450px] rounded-[24px] p-6 shadow-2xl border border-gray-100 relative">
            <h3 class="text-xl font-bold text-center text-gray-800 mb-1">Verifikasi Akun</h3>
            <p class="text-xs text-gray-500 text-center mb-5">
                Kode keamanan 6-digit dikirim ke email:<br>
                <strong class="text-gray-700">{{ session('registration_data.email') }}</strong>
            </p>
            
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-2.5 rounded-[12px] mb-4 text-xs text-center font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('register.verify') }}" method="POST" class="space-y-4"
                x-data="{
                    otp: ['', '', '', '', '', ''],
                    handleInput(e, index) {
                        let val = e.target.value.replace(/[^0-9]/g, '');
                        this.otp[index] = val;
                        e.target.value = val;

                        // Pindah otomatis ke kotak berikutnya
                        if (val && index < 5) {
                            let nextInput = document.getElementById('otp-' + (index + 1));
                            if (nextInput) nextInput.focus();
                        }
                    },
                    handleKeyDown(e, index) {
                        // Backspace untuk kembali ke kotak sebelumnya
                        if (e.key === 'Backspace' && !e.target.value && index > 0) {
                            let prevInput = document.getElementById('otp-' + (index - 1));
                            if (prevInput) prevInput.focus();
                        }
                    },
                    handlePaste(e) {
                        e.preventDefault();
                        let pasteData = (e.clipboardData || window.clipboardData).getData('text').trim().replace(/[^0-9]/g, '');
                        if (pasteData) {
                            let digits = pasteData.split('').slice(0, 6);
                            digits.forEach((digit, i) => {
                                this.otp[i] = digit;
                                let el = document.getElementById('otp-' + i);
                                if (el) el.value = digit;
                            });
                            let nextIdx = Math.min(digits.length, 5);
                            let nextEl = document.getElementById('otp-' + nextIdx);
                            if (nextEl) nextEl.focus();
                        }
                    }
                }">
                @csrf 
                
                <!-- Hidden Field untuk Mengirimkan 6 Digit OTP Gabungan ke Backend -->
                <input type="hidden" name="otp" :value="otp.join('')">

                <!-- 6 Input Box Manual (Pengganti template x-for) -->
                <div class="flex gap-2 justify-center my-3" @paste="handlePaste($event)">
                    <input type="text" id="otp-0" maxlength="1" inputmode="numeric" autocomplete="one-time-code"
                        @input="handleInput($event, 0)" @keydown="handleKeyDown($event, 0)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                    
                    <input type="text" id="otp-1" maxlength="1" inputmode="numeric"
                        @input="handleInput($event, 1)" @keydown="handleKeyDown($event, 1)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                    
                    <input type="text" id="otp-2" maxlength="1" inputmode="numeric"
                        @input="handleInput($event, 2)" @keydown="handleKeyDown($event, 2)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                    
                    <input type="text" id="otp-3" maxlength="1" inputmode="numeric"
                        @input="handleInput($event, 3)" @keydown="handleKeyDown($event, 3)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                    
                    <input type="text" id="otp-4" maxlength="1" inputmode="numeric"
                        @input="handleInput($event, 4)" @keydown="handleKeyDown($event, 4)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                    
                    <input type="text" id="otp-5" maxlength="1" inputmode="numeric"
                        @input="handleInput($event, 5)" @keydown="handleKeyDown($event, 5)"
                        class="w-11 h-12 text-center text-xl font-bold bg-[#f5d5d5] rounded-[12px] text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#c40000]">
                </div>

                <button type="submit" 
                    class="w-full bg-[#c40000] text-white py-3.5 rounded-[15px] font-bold text-sm tracking-wider transition-all duration-200 hover:bg-[#a10000]">
                    KONFIRMASI OTP
                </button>

                <div class="text-center pt-2 flex flex-col gap-2">
                    <template x-if="timer > 0">
                        <p class="text-xs text-gray-400">
                            Kirim ulang kode dalam <span x-text="Math.floor(timer / 60) + ':' + String(Math.floor(timer % 60)).padStart(2, '0')" class="font-bold text-gray-600"></span>
                        </p>
                    </template> 
                    <template x-if="timer <= 0">
                        <a href="{{ route('register.cancel') }}" 
                        class="text-xs text-[#c40000] hover:underline font-medium">
                            Tidak menerima kode? Kirim Ulang OTP
                        </a>
                    </template>
                </div>
            </form>
        </div>
    </div>
</body>
</html>