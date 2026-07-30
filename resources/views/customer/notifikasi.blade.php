@extends('layouts.customer')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full pt-4 mb-12 min-h-[60vh]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Judul --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa fa-bell text-brandRed"></i> Pusat Notifikasi
            </h1>
        </div>

        {{-- Container Kartu Notifikasi --}}
        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Filter & Action Header -->
            <div class="flex border-b border-gray-100 px-6 py-4 bg-gray-50/50 justify-between items-center">
                <div class="flex gap-4">
                    <a href="{{ route('customer.notifikasi') }}" 
                       class="text-xs font-bold pb-1 transition {{ !request('filter') ? 'text-brandRed border-b-2 border-brandRed' : 'text-gray-500 hover:text-brandRed' }}">
                       Semua
                    </a>
                    <a href="{{ route('customer.notifikasi', ['filter' => 'unread']) }}" 
                       class="text-xs font-bold pb-1 transition {{ request('filter') == 'unread' ? 'text-brandRed border-b-2 border-brandRed' : 'text-gray-500 hover:text-brandRed' }}">
                       Belum Dibaca
                    </a>
                </div>

                {{-- Form/Tombol Tandai Semua Sudah Dibaca --}}
                @if(isset($notifications) && $notifications->count() > 0)
                    <form action="{{ route('customer.notifikasi.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-brandRed transition cursor-pointer">
                            Tandai Semua Sudah Dibaca
                        </button>
                    </form>
                @endif
            </div>

            <!-- List Notifikasi -->
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    @php
                        $type = $notification->data['type'] ?? 'info';
                        $isUnread = is_null($notification->read_at);
                    @endphp

                    <div class="p-6 transition flex gap-4 items-start {{ $isUnread ? 'bg-red-50/10 hover:bg-red-50/20' : 'hover:bg-gray-50' }}">
                        
                        {{-- ICON DINAMIS BERDASARKAN TIPE --}}
                        @if($type === 'pesanan')
                            <div class="w-10 h-10 rounded-full bg-brandRed/10 text-brandRed flex items-center justify-center flex-shrink-0">
                                <i class="fa fa-shopping-bag text-base"></i>
                            </div>
                        @elseif($type === 'promo')
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa fa-tags text-base"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa fa-info-circle text-base"></i>
                            </div>
                        @endif

                        {{-- KONTEN NOTIFIKASI --}}
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1 gap-2">
                                <h3 class="text-sm font-bold {{ $isUnread ? 'text-gray-900' : 'text-gray-800' }}">
                                    {{ $notification->data['title'] ?? 'Pemberitahuan' }}
                                </h3>
                                <span class="text-[11px] text-gray-400 whitespace-nowrap">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-600 leading-relaxed mb-2">
                                {!! $notification->data['message'] ?? '' !!}
                            </p>

                            {{-- LINK AKSI DINAMIS --}}
                            @if(!empty($notification->data['url']))
                                <a href="{{ route('customer.notifikasi.read', ['id' => $notification->id, 'target' => $notification->data['url']]) }}" 
                                   class="inline-flex text-[11px] text-brandRed font-bold hover:underline items-center gap-1">
                                    {{ $notification->data['action_text'] ?? 'Lihat Detail' }} <i class="fa fa-arrow-right text-[9px]"></i>
                                </a>
                            @endif
                        </div>

                        {{-- INDIKATOR DOT BELUM DIBACA --}}
                        @if($isUnread)
                            <span class="w-2 h-2 rounded-full bg-brandRed mt-2 flex-shrink-0" title="Belum dibaca"></span>
                        @endif
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-4">
                            <i class="fa fa-bell-slash text-3xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Notifikasi</h3>
                        <p class="text-xs text-gray-400 text-center max-w-xs">
                            Semua pemberitahuan seputar pesanan, info toko, dan promo cetak akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION LINK --}}
            @if(method_exists($notifications, 'links') && $notifications->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $notifications->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection