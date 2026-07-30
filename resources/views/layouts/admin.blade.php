<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Fantastic Digital Printing</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" sizes="32x32">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-40 shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        </div>
        <div class="relative" x-data="{ open: false }">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-gray-700">
                    Selamat Datang, <strong class="text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</strong>
                </span>
                <button @click="open = !open" 
                        @click.away="open = false" 
                        class="w-9 h-9 rounded-full flex items-center justify-center border border-gray-300 transition focus:outline-none cursor-pointer overflow-hidden bg-gray-200 hover:bg-gray-300">
                    @php
                        $user = Auth::user();
                        $userEmail = $user->email ?? '';
                        $gravatarUrl = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($userEmail))) . '?d=404&s=200';
                        $profilePhoto = null;
                        if ($user && !empty($user->avatar)) {
                            $profilePhoto = asset('storage/' . $user->avatar);
                        } elseif ($user && !empty($user->profile_photo_path)) {
                            $profilePhoto = asset('storage/' . $user->profile_photo_path);
                        }
                    @endphp
                    @if($profilePhoto)
                        <img src="{{ $profilePhoto }}" alt="{{ $user->name ?? 'Admin' }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ $gravatarUrl }}" 
                             alt="{{ $user->name ?? 'Admin' }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.remove(); document.getElementById('default-avatar-btn').classList.remove('hidden');">
                        
                        <svg id="default-avatar-btn" class="w-5 h-5 text-gray-600 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    @endif
                </button>
            </div>
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 style="display: none;" 
                 class="absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                <div class="flex flex-col items-center pt-8 pb-6 px-6 bg-white">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200 text-gray-400 mb-3 overflow-hidden">
                        @if($profilePhoto)
                            <img src="{{ $profilePhoto }}" alt="{{ $user->name ?? 'Admin' }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ $gravatarUrl }}" 
                                 alt="{{ $user->name ?? 'Admin' }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.remove(); document.getElementById('default-avatar-popover').classList.remove('hidden');">
                            <svg id="default-avatar-popover" class="w-12 h-12 text-gray-400 hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-800 text-base tracking-wide uppercase text-center">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </h3>
                </div>
                <div class="border-t border-gray-100"></div>
                <div class="p-6 space-y-4 text-left">
                    <div class="flex items-start gap-3">
                        <div class="text-gray-400 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">EMAIL</p>
                            <p class="text-xs font-bold text-gray-700 break-all">
                                {{ Auth::user()->email ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-gray-400 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">NOMOR TELEPON</p>
                            <p class="text-xs font-bold text-gray-700">
                                {{ Auth::user()->no_hp ?? Auth::user()->phone ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="flex flex-1">
        <aside class="w-64 bg-red-700 text-white flex flex-col justify-between min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-4">
                <nav class="space-y-1 px-2">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk') }}" class="{{ request()->routeIs('admin.produk*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="{{ request()->routeIs('admin.kategori*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Kategori
                    </a>
                    <a href="{{ route('admin.pesanan') }}" class="{{ request()->routeIs('admin.pesanan*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Pesanan
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="{{ request()->routeIs('admin.pembayaran*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Pembayaran
                    </a>
                    <a href="{{ route('admin.promo') }}" class="{{ request()->routeIs('admin.promo*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        Promo & Pengumuman
                    </a>
                    <a href="{{ route('admin.pelanggan') }}" class="{{ request()->routeIs('admin.pelanggan*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Laporan
                    </a>
                    <a href="{{ route('admin.pengaturan') }}" class="{{ request()->routeIs('admin.pengaturan*') ? 'bg-red-800' : 'hover:bg-red-600/50' }} flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pengaturan
                    </a>
                </nav>
            </div>
            <div class="p-3 border-t border-red-800" x-data>
                <button type="button" 
                        @click="$dispatch('open-logout-modal')" 
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition uppercase tracking-wider text-white cursor-pointer shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log Out
                </button>
            </div>
        </aside>
        <main class="flex-1 p-6 space-y-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @stack('modals')

    <div x-data="{ openLogout: false }" 
         @open-logout-modal.window="openLogout = true" 
         @keydown.escape.window="openLogout = false"
         class="relative z-50">
        <div x-show="openLogout" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;" 
             class="fixed inset-0 bg-black/40 backdrop-blur-md transition-opacity"></div>
        <div x-show="openLogout" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl border border-gray-100 relative overflow-hidden"
                 @click.away="openLogout = false">
                <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Konfirmasi Keluar
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6 px-2">
                    Apakah Anda yakin ingin keluar dari akun Fantastic Digital Printing?
                </p>
                <div class="flex items-center gap-3">
                    <button type="button" 
                            @click="openLogout = false" 
                            class="flex-1 py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-xs hover:bg-gray-50 transition cursor-pointer">
                        Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-red-600 text-white font-semibold text-xs hover:bg-red-700 transition cursor-pointer shadow-sm">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>