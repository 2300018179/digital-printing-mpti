@extends('layouts.customer')

@section('title', 'Promo Spesial - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-4 w-full pt-6 mb-16 min-h-[60vh]">
    <div class="max-w-6xl mx-auto">
        
        <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
                    <i class="fa fa-tags text-brandRed"></i> Promo Spesial
                </h1>
                <p class="text-xs text-gray-500 mt-1">Gunakan kode voucher di bawah saat checkout untuk klaim diskon istimewa.</p>
            </div>
        </div>

        @if(isset($promos) && $promos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                @foreach($promos as $promo)
                    <div class="relative bg-white rounded-2xl border border-gray-100 shadow-[0_8px_25px_rgba(0,0,0,0.05)] overflow-hidden flex flex-row items-stretch hover:shadow-[0_12px_30px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-[120px] md:w-[140px] bg-gradient-to-br from-brandRed to-red-700 shrink-0 flex flex-col items-center justify-center text-white p-4 text-center relative overflow-hidden">
                            <div class="absolute -left-6 -top-6 w-16 h-16 bg-white/10 rounded-full blur-sm"></div>
                            <span class="text-[10px] uppercase font-bold tracking-widest text-white/80">HEMAT</span>
                            <div class="my-1 flex items-baseline justify-center">
                                <span class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ $promo->diskon }}</span>
                                <span class="text-lg font-bold">%</span>
                            </div>
                            <span class="text-[9px] bg-white/20 backdrop-blur-md px-2 py-0.5 rounded-full font-medium text-white/90 uppercase">Voucher</span>
                        </div>
                        <div class="relative flex flex-col justify-between items-center py-2 z-10">
                            <div class="w-4 h-4 bg-gray-50 border-b border-gray-200 rounded-full -mt-4 shadow-inner"></div>
                            <div class="h-full border-r-2 border-dashed border-gray-200 my-1"></div>
                            <div class="w-4 h-4 bg-gray-50 border-t border-gray-200 rounded-full -mb-4 shadow-inner"></div>
                        </div>
                        <div class="flex-1 p-5 flex flex-col justify-between pl-4">
                            <div>
                                <div class="flex justify-between items-start gap-2 mb-1">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-brandRed transition-colors line-clamp-1">
                                        {{ $promo->nama }}
                                    </h3>
                                </div>
                                <button type="button" onclick="salinKode('{{ $promo->kode }}', this)" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-2.5 py-1 rounded-lg text-xs font-mono font-semibold text-gray-700 mt-1 cursor-pointer transition-colors">
                                    <i class="far fa-copy text-gray-400 text-[11px]"></i>
                                    <span class="tracking-wide uppercase">{{ $promo->kode }}</span>
                                    <span class="text-[10px] text-green-600 font-sans hidden msg-tersalin font-bold ml-1">✓ Tersalin</span>
                                </button>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-3">
                                <span class="text-[11px] text-gray-500 font-medium flex items-center gap-1">
                                    <i class="far fa-clock text-brandRed"></i> s/d {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                                </span>
                                <a href="{{ route('customer.semua-produk') }}" 
                                   onclick="pakaiPromo('{{ $promo->kode }}')"
                                   class="px-4 py-1.5 bg-brandRed text-white text-xs font-bold rounded-xl shadow-md shadow-red-500/10 hover:bg-red-700 hover:shadow-lg transition-all no-underline">
                                    Pakai <i class="fa fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-16 px-4 flex flex-col items-center justify-center min-h-[350px]">
                <div class="w-20 h-20 rounded-2xl bg-red-50 text-brandRed flex items-center justify-center mb-4">
                    <i class="fa fa-ticket-alt text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Promo Aktif</h3>
                <p class="text-xs text-gray-400 text-center max-w-xs mb-6">
                    Saat ini belum ada voucher promo yang tersedia. Silakan cek kembali di lain waktu!
                </p>
                <a href="{{ route('customer.semua-produk') }}" class="px-6 py-2.5 bg-brandRed text-white rounded-xl font-bold text-xs tracking-wider transition-all duration-300 hover:bg-red-700 shadow-md shadow-red-500/20 no-underline">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function salinKode(kode, element) {
    navigator.clipboard.writeText(kode).then(() => {
        localStorage.setItem('active_promo_code', kode);
        
        const msg = element.querySelector('.msg-tersalin');
        if (msg) {
            msg.classList.remove('hidden');
            setTimeout(() => {
                msg.classList.add('hidden');
            }, 2000);
        }
    });
}

function pakaiPromo(kode) {

    localStorage.setItem('active_promo_code', kode);
}
</script>
@endsection