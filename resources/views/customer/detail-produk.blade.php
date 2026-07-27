@extends('layouts.customer')

@section('title', 'Detail Produk - Fantastic Digital Printing')

@section('content')

<div class="max-w-[1350px] mx-auto px-[15px] w-full pt-12">
            
    {{-- PART 1: DETAIL PRODUK (DINAMIS) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start mb-8">
        <div class="w-full aspect-[4/3] max-w-[500px] border border-brandRed rounded-[25px] p-6 flex items-center justify-center bg-white shadow-[0_4px_12px_rgba(0,0,0,0.02)] mx-auto lg:ml-0">
            @if($product->image)
                <img src="{{ asset('assets/products/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
            @else
                <div class="text-gray-300 flex flex-col items-center">
                    <i class="fa fa-image text-5xl mb-2"></i>
                    <span class="text-xs">Tidak ada gambar</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col items-start pt-2">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 font-inder">{{ $product->name }}</h1>
            
            <div class="bg-brandRed text-white font-semibold text-sm p-[8px_25px] rounded-[20px] mb-5 shadow-sm">
                Rp. {{ number_format($product->price ?? 0, 0, ',', '.') }}/{{ $product->unit ?? 'pcs' }}
            </div>

            <h3 class="text-sm font-bold text-gray-700 mb-2">Spesifikasi Produk</h3>
            <div class="prose prose-sm text-sm text-gray-600 font-medium">
                @if(!empty($product->description))
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach(explode(',', $product->description) as $item)
                            <li class="capitalize-first">{{ trim($item) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Tidak ada spesifikasi produk.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- PART 2: FORM ORDER & INTEGRASI MEDIA UPLOAD --}}
    <form id="orderForm" action="{{ route('customer.pembayaran') }}" method="POST" enctype="multipart/form-data" onsubmit="clearAllSessionCache()" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch mb-16">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="cart_id_edit" value="{{ $editCartData->id ?? '' }}">
        
        {{-- KOLOM KIRI: Parameter Cetak --}}
        <div class="bg-white border border-gray-200 rounded-[20px] p-6 shadow-[0_4px_15px_rgba(0,0,0,0.05)] flex flex-col justify-between">
            <div>
                <h2 class="text-center font-bold text-gray-700 border-b border-gray-100 pb-3 mb-5 text-sm tracking-wide">
                    {{ isset($editCartData) ? 'Form Edit Order' : 'Form Order' }}
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            Jumlah 
                            @if(($product->minimum_order ?? 1) > 1)
                                <span class="text-brandRed text-[11px] font-normal">(Minimal pembelian: {{ $product->minimum_order }} {{ $product->unit ?? 'pcs' }})</span>
                            @endif
                        </label>
                        <input type="number" 
                            required 
                            min="{{ $product->minimum_order ?? 1 }}" 
                            value="{{ $editCartData->quantity ?? ($product->minimum_order ?? 1) }}" 
                            name="jumlah" 
                            id="inputJumlah" 
                            class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Tambahan</label>
                        <textarea name="catatan" rows="4" placeholder="Tuliskan instruksi pemotongan, jenis bahan, atau laminasi di sini..." class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed resize-none">{{ $editCartData->notes ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Manajemen Berkas Desain --}}
        <div class="bg-white border border-gray-200 rounded-[20px] p-6 shadow-[0_4px_15px_rgba(0,0,0,0.05)] flex flex-col justify-between">
            <div>
                <h2 class="text-center font-bold text-gray-700 border-b border-gray-100 pb-3 mb-5 text-sm tracking-wide">Upload Desain</h2>
                
                {{-- Switcher Tab Desain --}}
                <div class="grid grid-cols-2 gap-2 bg-gray-100 rounded-[10px] p-1 mb-5">
                    <button type="button" id="tabUpload" onclick="switchTab('upload')" class="bg-gray-300 text-gray-700 font-semibold text-xs py-2 rounded-[8px] shadow-sm transition-all cursor-pointer">Upload File</button>
                    <button type="button" id="tabLink" onclick="switchTab('link')" class="text-gray-500 font-semibold text-xs py-2 rounded-[8px] hover:text-gray-700 transition-all cursor-pointer">Link Desain</button>
                </div>

                {{-- Panel A: Berkas Fisik --}}
                <div id="contentUpload" class="border border-dashed border-gray-300 rounded-[15px] p-6 flex flex-col items-center justify-center text-center space-y-3 bg-white h-[170px] w-full transition-all relative">
                    <div id="uploadInitial" class="flex flex-col items-center justify-center space-y-3 w-full">
                        <i class="fa fa-cloud-arrow-up text-2xl text-gray-400"></i>
                        <p class="text-xs font-medium text-gray-500 max-w-[240px] leading-relaxed">
                            Drag & Drop file desain Anda di sini atau klik untuk memilih file
                        </p>
                        <button type="button" onclick="document.getElementById('file-upload').click()" class="bg-brandRed text-white text-[11px] font-semibold p-[5px_20px] rounded-[15px] shadow-sm cursor-pointer hover:bg-red-700 transition">
                            Pilih File
                        </button>
                    </div>

                    <div id="uploadSuccess" class="hidden w-full flex items-center justify-center">
                        <div class="border border-gray-200 rounded-lg p-3 flex items-center gap-3 bg-white shadow-sm max-w-[280px]">
                            <i class="fa-solid fa-file-pdf text-red-500 text-lg" id="fileIcon"></i>
                            <span id="fileNameDisplay" class="text-xs text-gray-700 font-medium truncate max-w-[180px]">Nama_File.pdf</span>
                            <button type="button" onclick="clearUpload('upload')" class="text-gray-400 hover:text-brandRed font-bold text-sm cursor-pointer ml-auto transition-colors px-1">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    {{-- NAMA INPUT DISESUAIKAN JADI file_desain --}}
                    <input type="file" name="file_desain" id="file-upload" class="hidden" onchange="handleFileSelect(this)">
                </div>

                {{-- Panel B: Tautan Eksternal (Cloud) --}}
                <div id="contentLink" class="hidden border border-dashed border-gray-300 rounded-[15px] p-6 flex flex-col items-center justify-center text-center bg-white h-[170px] w-full transition-all relative">
                    <div id="linkInitial" class="w-full max-w-[320px] flex flex-col items-center justify-center space-y-3 my-auto">
                        <label class="block text-center text-xs font-semibold text-gray-700">Link Google Drive / Dropbox / Canva</label>
                        {{-- NAMA INPUT DISESUAIKAN JADI link_desain --}}
                        <input type="url" id="link-input" name="link_desain" 
                            value="{{ ($editCartData && (filter_var($editCartData->desain, FILTER_VALIDATE_URL) || str_contains($editCartData->desain, 'http'))) ? $editCartData->desain : '' }}"
                            placeholder="https://drive.google.com/..." oninput="handleLinkInput(this)" class="w-full border border-gray-300 rounded-[12px] p-[10px_15px] text-xs outline-none focus:border-brandRed text-center">
                    </div>

                    <div id="linkSuccess" class="hidden w-full flex items-center justify-center">
                        <div class="border border-gray-200 rounded-lg p-3 flex items-center gap-3 bg-white shadow-sm w-full max-w-[300px]">
                            <i class="fa-solid fa-link text-blue-500 text-sm"></i>
                            <span id="linkNameDisplay" class="text-xs text-gray-700 font-medium truncate max-w-[200px]">https://link-kamu...</span>
                            <button type="button" onclick="clearUpload('link')" class="text-gray-400 hover:text-brandRed font-bold text-sm cursor-pointer ml-auto transition-colors px-1">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @if($editCartData && $editCartData->desain)
                    <div id="containerDesainLama" class="mt-3 p-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-between text-[11px] text-gray-500">
                        <div class="flex items-center gap-2 truncate">
                            <i class="fa-solid fa-circle-info text-brandRed text-xs shrink-0"></i>
                            <span class="truncate"> Desain saat ini: 
                                <strong class="text-gray-700" id="namaFileLama">{{ basename($editCartData->desain) }}</strong> 
                            </span>
                        </div>
                        <button type="button" onclick="hapusDesainLama()" class="text-gray-400 hover:text-brandRed font-bold transition-colors px-1 cursor-pointer" title="Hapus desain ini">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <input type="hidden" name="hapus_desain_lama" id="hapusDesainLamaInput" value="0">
                @endif
            </div>

            <div class="mt-8 flex items-center justify-center gap-4">
                <button type="button" onclick="addToCart()" class="w-full max-w-[160px] p-[10px_0] bg-white text-brandRed border border-brandRed rounded-[25px] font-bold text-sm tracking-wide text-center transition-all duration-300 hover:bg-brandRed hover:text-white hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] cursor-pointer">
                    {{ isset($editCartData) ? 'Simpan Edit' : '+ Keranjang' }}
                </button>
                
                <button type="submit" class="w-full max-w-[160px] p-[10px_0] bg-brandRed text-white border border-brandRed rounded-[25px] font-bold text-sm tracking-wide text-center transition-all duration-300 hover:bg-white hover:text-brandRed hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] cursor-pointer">
                    Beli Sekarang
                </button>
            </div>
        </div>
    </form>
</div>

<div id="customConfirmModal" class="hidden fixed top-0 left-0 right-0 bottom-0 w-full h-full min-h-screen z-[99999] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-[20px] shadow-[0_10px_30px_rgba(0,0,0,0.2)] w-full max-w-[400px] p-6 text-center transform scale-95 transition-transform duration-300 mx-4">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 text-brandRed mb-4">
            <i class="fa-solid fa-trash-can text-2xl"></i>
        </div>
        
        <h3 class="text-base font-bold text-gray-800 mb-2">Hapus Berkas Desain?</h3>
        <p class="text-xs text-gray-500 leading-relaxed mb-6">
            Apakah Anda yakin ingin menghapus berkas desain lama dari item keranjang ini? Tindakan ini tidak dapat dibatalkan.
        </p>
        
        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeConfirmModal()" class="w-1/2 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-xs rounded-[15px] transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="executeHapusDesainLama()" class="w-1/2 py-2.5 bg-brandRed hover:bg-red-700 text-white font-semibold text-xs rounded-[15px] shadow-sm shadow-red-200 transition cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        checkPersistedData();
    });

    function switchTab(tab) {
        const btnUpload = document.getElementById('tabUpload');
        const btnLink = document.getElementById('tabLink');
        const panelUpload = document.getElementById('contentUpload');
        const panelLink = document.getElementById('contentLink');
        const fileInput = document.getElementById('file-upload');
        const linkInput = document.getElementById('link-input');

        if (tab === 'upload') {
            btnUpload.className = "bg-gray-300 text-gray-700 font-semibold text-xs py-2 rounded-[8px] shadow-sm transition-all cursor-pointer";
            btnLink.className = "text-gray-500 font-semibold text-xs py-2 rounded-[8px] hover:text-gray-700 transition-all cursor-pointer";
            panelUpload.classList.remove('hidden');
            panelLink.classList.add('hidden');
            if(linkInput && !sessionStorage.getItem('cached_link_url')) linkInput.value = ''; 
        } else {
            btnLink.className = "bg-gray-300 text-gray-700 font-semibold text-xs py-2 rounded-[8px] shadow-sm transition-all cursor-pointer";
            btnUpload.className = "text-gray-500 font-semibold text-xs py-2 rounded-[8px] hover:text-gray-700 transition-all cursor-pointer";
            panelLink.classList.remove('hidden');
            panelUpload.classList.add('hidden');
            if(fileInput && !sessionStorage.getItem('cached_file_name')) fileInput.value = '';
        }
    }

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            sessionStorage.setItem('cached_file_name', file.name);
            sessionStorage.setItem('cached_page_url', window.location.href); 
            showUploadSuccess(file.name);
        }
    }

    function handleLinkInput(input) {
        if (input.value.trim() !== "") {
            sessionStorage.setItem('cached_link_url', input.value);
            sessionStorage.setItem('cached_page_url', window.location.href);
            showLinkSuccess(input.value);
        }
    }

    function showUploadSuccess(fileName) {
        document.getElementById('uploadInitial').classList.add('hidden');
        document.getElementById('uploadSuccess').classList.remove('hidden');
        document.getElementById('fileNameDisplay').innerText = fileName;

        const ext = fileName.split('.').pop().toLowerCase();
        const iconEl = document.getElementById('fileIcon');
        if (['jpg', 'jpeg', 'png'].includes(ext)) {
            iconEl.className = "fa-solid fa-file-image text-emerald-500 text-lg";
        } else if (ext === 'pdf') {
            iconEl.className = "fa-solid fa-file-pdf text-red-500 text-lg";
        } else {
            iconEl.className = "fa-solid fa-file-zipper text-amber-500 text-lg";
        }
    }

    function showLinkSuccess(url) {
        document.getElementById('linkInitial').classList.add('hidden');
        document.getElementById('linkSuccess').classList.remove('hidden');
        document.getElementById('linkNameDisplay').innerText = url;
    }

    function checkPersistedData() {
        const cachedFile = sessionStorage.getItem('cached_file_name');
        const cachedLink = sessionStorage.getItem('cached_link_url');
        const cachedUrl = sessionStorage.getItem('cached_page_url');
        const currentUrl = window.location.href;

        if (cachedUrl && cachedUrl !== currentUrl) {
            clearAllSessionCache();
            return;
        }

        if (cachedFile) {
            switchTab('upload');
            showUploadSuccess(cachedFile);
        } else if (cachedLink) {
            switchTab('link');
            showLinkSuccess(cachedLink);
            const linkInput = document.getElementById('link-input');
            if(linkInput) linkInput.value = cachedLink;
        }
    }

    function clearUpload(type) {
        if (type === 'upload') {
            sessionStorage.removeItem('cached_file_name');
            const fileInput = document.getElementById('file-upload');
            if(fileInput) fileInput.value = "";
            document.getElementById('uploadSuccess').classList.add('hidden');
            document.getElementById('uploadInitial').classList.remove('hidden');
        } else if (type === 'link') {
            sessionStorage.removeItem('cached_link_url');
            const linkInput = document.getElementById('link-input');
            if(linkInput) linkInput.value = "";
            document.getElementById('linkSuccess').classList.add('hidden');
            document.getElementById('linkInitial').classList.remove('hidden');
        }
        
        if (!sessionStorage.getItem('cached_file_name') && !sessionStorage.getItem('cached_link_url')) {
            sessionStorage.removeItem('cached_page_url');
        }
    }

    function clearAllSessionCache() {
        sessionStorage.removeItem('cached_file_name');
        sessionStorage.removeItem('cached_link_url');
        sessionStorage.removeItem('cached_page_url');
    }

    let isSubmittingOrder = false;

    function addToCart() {
        const form = document.getElementById('orderForm');
        const inputJumlah = document.getElementById('inputJumlah');
        
        if (!inputJumlah.value || parseInt(inputJumlah.value) < parseInt(inputJumlah.min)) {
            alert('Jumlah pembelian kurang dari batas minimum order!');
            inputJumlah.focus();
            return;
        }

        isSubmittingOrder = true; 
        form.action = "{{ url('keranjang/tambah') }}/{{ $product->id }}"; 
        form.submit();
    }

    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const inputJumlah = document.getElementById('inputJumlah');
        if (!inputJumlah.value || parseInt(inputJumlah.value) < parseInt(inputJumlah.min)) {
            alert('Jumlah pembelian kurang dari batas minimum order!');
            inputJumlah.focus();
            return;
        }

        isSubmittingOrder = true;
        this.action = "{{ url('keranjang/tambah') }}/{{ $product->id }}?checkout_langsung=true"; 
        this.submit();
    });

    function hapusDesainLama() {
        const modal = document.getElementById('customConfirmModal');
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
            }, 10);
        }
    }

    function executeHapusDesainLama() {
        const hapusInput = document.getElementById('hapusDesainLamaInput');
        const containerLama = document.getElementById('containerDesainLama');
        
        if (hapusInput) hapusInput.value = "1";
        if (containerLama) containerLama.classList.add('hidden');
        
        closeConfirmModal();
    }

    function closeConfirmModal() {
        const modal = document.getElementById('customConfirmModal');
        if (modal) {
            modal.querySelector('.transform').classList.add('scale-95');
            modal.classList.add('hidden');
        }
    }

    window.addEventListener('beforeunload', function (e) {
        if (isSubmittingOrder) {
            clearAllSessionCache();
        } 
        else if (performance.navigation.type === performance.navigation.TYPE_RELOAD || 
                (performance.getEntriesByType("navigation")[0] && performance.getEntriesByType("navigation")[0].type === "reload")) {
        } 
        else {
            clearAllSessionCache();
        }
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            checkPersistedData();
        }
    });
</script>
@endsection