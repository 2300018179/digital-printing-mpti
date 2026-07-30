@extends('layouts.customer')

@section('content')
<div class="max-w-[1000px] mx-auto px-[15px] w-full pt-6 pb-16">
    <form id="form-pembayaran" action="{{ route('customer.pembayaran.simpan') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[30px] shadow-[0_10px_30px_rgba(0,0,0,0.04)] border border-gray-100 p-6 md:p-10">
        @csrf
        @foreach($checkoutItems as $item)
            <input type="hidden" name="selected_items[]" value="{{ $item['id'] }}">
        @endforeach
        
        {{-- Hidden Input Promo, Grand Total, Nominal Bayar & Sisa Tagihan --}}
        <input type="hidden" name="kode_promo" id="input_kode_promo_hidden" value="">
        <input type="hidden" name="grand_total" id="input_grand_total_hidden" value="{{ $grandTotal }}">
        <input type="hidden" name="nominal_dibayar" id="input_nominal_dibayar_hidden" value="{{ $uangMuka }}">
        <input type="hidden" name="sisa_tagihan" id="input_sisa_tagihan_hidden" value="{{ $grandTotal - $uangMuka }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
            <div class="space-y-6 md:border-r md:border-gray-100 md:pr-10">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 tracking-wide">Selesaikan Pembayaran</h1>
                    <p class="text-xs text-gray-400 mt-1">Silakan pilih jenis pembayaran dan scan QRIS di sebelah kanan.</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-4 space-y-4 text-sm">
                    <div class="space-y-3">
                        @foreach($checkoutItems as $item)
                            <div class="flex justify-between items-start text-xs text-gray-500">
                                <div class="max-w-[70%]">
                                    <span class="font-semibold text-gray-800 block leading-tight">{{ $item['nama'] }}</span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5 font-harga">
                                        {{ $item['jumlah'] }} pcs × Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="font-medium text-gray-800 mt-0.5 font-harga">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- FITUR KODE PROMO / VOUCHER --}}
                    <div class="border-t border-gray-200/60 pt-3">
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5 flex items-center gap-1">
                            <i class="fa fa-ticket-alt text-brandRed"></i> Kode Voucher / Promo
                        </label>
                        <div class="flex gap-2">
                            <input type="text" id="input_kode_promo" placeholder="Masukkan kode promo" class="flex-1 bg-white border border-gray-200 rounded-xl px-3 py-2 text-xs uppercase font-mono font-bold focus:outline-none focus:border-brandRed uppercase transition">
                            <button type="button" id="btn_apply_promo" onclick="terapkanPromoManual()" class="px-3.5 py-2 bg-gray-800 hover:bg-black text-white rounded-xl text-xs font-bold transition shrink-0">
                                Pasang
                            </button>
                        </div>
                        <div id="promo_status_msg" class="text-[11px] mt-1.5 font-semibold hidden"></div>
                    </div>

                    <div class="border-t border-gray-200/60 my-2"></div>
                    
                    {{-- RINCIAN HARGA --}}
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Total Harga Cetak</span>
                            <span class="font-medium text-gray-700 font-harga">Rp {{ number_format($hargaCetak, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Biaya Layanan</span>
                            <span class="font-medium text-gray-700 font-harga">Rp {{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                        </div>
                        
                        {{-- ROW POTONGAN DISKON --}}
                        <div id="row_diskon" class="flex justify-between text-xs text-emerald-600 font-bold hidden">
                            <span class="flex items-center gap-1"><i class="fa fa-percentage"></i> Diskon Promo</span>
                            <span class="font-harga" id="text_nominal_diskon">- Rp 0</span>
                        </div>

                        <div class="border-t border-dashed border-gray-200 pt-2 flex justify-between font-bold text-base text-gray-800">
                            <span>Grand Total</span>
                            <span class="text-brandRed font-harga" id="display_grand_total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700 block">Metode Pembayaran:</label> 
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label id="label-dp" class="border-2 border-brandRed bg-red-50/30 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all">
                            <input type="radio" name="payment_type" value="dp" checked onchange="handlePaymentTypeChange()" class="absolute top-3 right-3 accent-brandRed">
                            <span class="text-xs font-bold text-brandRed tracking-wide uppercase">Uang Muka (DP 50%)</span>
                            <span class="text-lg font-bold text-gray-800 mt-2 font-harga" id="display_dp_nominal">Rp {{ number_format($uangMuka, 0, ',', '.') }}</span>
                        </label>
                        <label id="label-full" class="border border-gray-200 hover:border-gray-300 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all">
                            <input type="radio" name="payment_type" value="full" onchange="handlePaymentTypeChange()" class="absolute top-3 right-3 accent-brandRed">
                            <span class="text-xs font-bold text-gray-400 tracking-wide uppercase">Bayar Lunas (100%)</span>
                            <span class="text-lg font-bold text-gray-800 mt-2 font-harga" id="display_full_nominal">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </label>
                    </div>
                </div>

                <div id="info-pembayaran" class="text-[11px] text-gray-400 bg-amber-50/50 text-amber-700 border border-amber-100 rounded-xl p-3 flex gap-2 items-start">
                    <i class="fas fa-info-circle mt-0.5 shrink-0"></i>
                    <p id="info-text">Jika memilih opsi <strong>DP 50%</strong>, sisa pelunasan sebesar <strong class="font-harga" id="display_sisa_pelunasan">Rp {{ number_format($grandTotal - $uangMuka, 0, ',', '.') }}</strong> dibayarkan saat Anda mengambil produk di toko.</p>
                </div>
            </div>

            <div class="space-y-6 w-full">
                @php
                    $settingsData = $settings ?? $appSettings ?? [];
                    $qrisImage = $settingsData['qris_image'] ?? null;
                    $qrisUrl = $qrisImage 
                        ? (str_starts_with($qrisImage, 'http') ? $qrisImage : asset('storage/' . $qrisImage))
                        : asset('assets/icons/bayar.png');
                @endphp
                <div class="flex flex-col items-center text-center">
                    <span class="text-xs font-semibold text-gray-400 tracking-wider mb-1">QRIS PAYMENT</span>
                    <h3 class="font-bold text-sm text-gray-800 mb-3">
                        {{ $settingsData['qris_nama_pemilik'] ?? $settingsData['nama_toko'] ?? '' }}
                    </h3>
                    <div class="p-3 bg-white border border-gray-100 rounded-2xl shadow-sm mb-4">
                        <img src="{{ $qrisUrl }}" alt="QRIS Code" class="w-48 h-48 object-contain rounded-lg">
                    </div>
                    <div class="bg-brandRed text-white px-6 py-2 rounded-full font-bold text-base mb-2 shadow-sm inline-block">
                        <span id="badge-nominal" class="font-harga">Rp {{ number_format($uangMuka, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">*Pastikan nominal transfer sesuai angka di atas</p>
                </div>

                <div class="w-full px-1">
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        <i class="fa fa-upload text-brandRed mr-1"></i> Upload Bukti Transfer <span class="text-red-500">*</span>
                    </label>
                    <div class="relative border-2 border-dashed border-gray-200 hover:border-brandRed transition rounded-xl p-4 bg-gray-50/50 text-center cursor-pointer group" id="upload-container">
                        <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-1.5 py-2" id="upload-placeholder">
                            <i class="fa fa-cloud-upload-alt text-2xl text-gray-400 group-hover:text-brandRed transition-colors"></i>
                            <p class="text-xs font-semibold text-gray-600">Pilih Berkas atau Tarik ke Sini</p>
                            <p class="text-[10px] text-gray-400">Format berkas: JPG, PNG, JPEG (Maks. 2MB)</p>
                        </div>
                        <div id="image-preview" class="hidden flex flex-col items-center py-1">
                            <img id="preview-src" src="#" alt="Preview Bukti" class="max-h-24 object-contain rounded-lg border border-gray-200 mb-1.5 shadow-sm">
                            <span id="file-name-text" class="text-[11px] text-gray-500 font-medium truncate max-w-[250px] block"></span>
                            <button type="button" id="remove-preview-btn" class="text-[10px] text-brandRed font-bold hover:underline mt-1 z-20 relative">Ganti Foto</button>
                        </div>
                    </div>
                    @error('bukti_transfer')
                        <p class="text-red-500 text-[11px] mt-1 text-left font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOMBOL BAYAR DENGAN INTERUPSI AUTH CHECK --}}
                <div class="px-1 pt-1">
                    @auth
                        <button type="submit" class="w-full py-3.5 bg-brandRed text-white font-bold text-sm rounded-full hover:bg-red-700 active:scale-[0.99] transition shadow-md uppercase tracking-wider cursor-pointer">
                            SAYA SUDAH BAYAR
                        </button>
                    @else
                        <button type="button" onclick="openAuthModal()" class="w-full py-3.5 bg-brandRed text-white font-bold text-sm rounded-full hover:bg-red-700 active:scale-[0.99] transition shadow-md uppercase tracking-wider cursor-pointer">
                            SAYA SUDAH BAYAR
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </form>
</div>

{{-- MODAL INTERUPSI AUTH CHECK (GUEST USER) --}}
<div id="authModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 text-center shadow-xl">
        <div class="w-16 h-16 bg-red-100 text-brandRed rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fas fa-user-lock"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Login Diperlukan</h3>
        <p class="text-gray-600 text-xs mb-6 leading-relaxed">Anda belum masuk. Silakan login atau mendaftar akun terlebih dahulu untuk melanjutkan dan menyimpan transaksi ini.</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeAuthModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                Batal
            </button>
            <a href="{{ route('login') }}" class="flex-1 py-2.5 bg-brandRed text-white rounded-xl text-xs font-bold hover:bg-red-700 text-center no-underline transition">
                Login Sekarang
            </a>
        </div>
    </div>
</div>

<script>
    // State Variabel Kalkulasi Total
    let initialHargaCetak = {{ $hargaCetak }};
    let initialBiayaLayanan = {{ $biayaLayanan }};
    let initialGrandTotal = {{ $grandTotal }};
    
    let currentNominalDiskon = 0;
    let currentGrandTotal = initialGrandTotal;
    let currentUangMuka = {{ $uangMuka }};

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(Math.max(0, angka));
    }

    const databasePromo = {
        'HUTRI12': { tipe: 'potongan', nilai: 2000 },
        'PROMO50': { tipe: 'persen', nilai: 50 },
        'HEMAT10': { tipe: 'potongan', nilai: 1000 }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const savedPromo = localStorage.getItem('active_promo_code');
        if (savedPromo) {
            const inputPromo = document.getElementById('input_kode_promo');
            if (inputPromo) {
                inputPromo.value = savedPromo;
                terapkanPromoManual(true);
            }
        }

        const fileInput = document.getElementById('bukti_transfer');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const imagePreview = document.getElementById('image-preview');
        const previewSrc = document.getElementById('preview-src');
        const fileNameText = document.getElementById('file-name-text');
        const removePreviewBtn = document.getElementById('remove-preview-btn');

        if(fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewSrc.src = event.target.result;
                        fileNameText.textContent = file.name;
                        uploadPlaceholder.classList.add('hidden');
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        if(removePreviewBtn) {
            removePreviewBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.value = '';
                uploadPlaceholder.classList.remove('hidden');
                imagePreview.classList.add('hidden');
            });
        }
    });

    function terapkanPromoManual(isAuto = false) {
        const inputKodeElement = document.getElementById('input_kode_promo');
        const inputKode = inputKodeElement.value.trim().toUpperCase();
        const msgBox = document.getElementById('promo_status_msg');
        const rowDiskon = document.getElementById('row_diskon');
        const textNominalDiskon = document.getElementById('text_nominal_diskon');

        if (!inputKode) {
            msgBox.className = "text-[11px] mt-1.5 font-semibold text-red-500 block";
            msgBox.innerText = "Masukkan kode promo terlebih dahulu.";
            resetPromo();
            return;
        }

        let promoData = databasePromo[inputKode];
        if (!promoData) {
            msgBox.className = "text-[11px] mt-1.5 font-semibold text-red-500 block";
            msgBox.innerText = "Kode promo tidak valid atau sudah kadaluarsa.";
            resetPromo();
            return;
        }

        if (promoData.tipe === 'persen') {
            currentNominalDiskon = (initialHargaCetak * promoData.nilai) / 100;
        } else {
            currentNominalDiskon = promoData.nilai;
        }

        if (currentNominalDiskon > initialGrandTotal) {
            currentNominalDiskon = initialGrandTotal;
        }

        currentGrandTotal = initialGrandTotal - currentNominalDiskon;
        currentUangMuka = Math.ceil(currentGrandTotal / 2);

        msgBox.className = "text-[11px] mt-1.5 font-semibold text-emerald-600 block";
        msgBox.innerText = "✓ Voucher " + inputKode + " berhasil dipasang!";
        
        if (rowDiskon && textNominalDiskon) {
            rowDiskon.classList.remove('hidden');
            textNominalDiskon.innerText = "- Rp " + formatRupiah(currentNominalDiskon);
        }

        document.getElementById('display_grand_total').innerText = "Rp " + formatRupiah(currentGrandTotal);
        document.getElementById('display_dp_nominal').innerText = "Rp " + formatRupiah(currentUangMuka);
        document.getElementById('display_full_nominal').innerText = "Rp " + formatRupiah(currentGrandTotal);
        
        document.getElementById('input_kode_promo_hidden').value = inputKode;
        document.getElementById('input_grand_total_hidden').value = currentGrandTotal;

        handlePaymentTypeChange();
        localStorage.removeItem('active_promo_code');
    }

    function resetPromo() {
        currentNominalDiskon = 0;
        currentGrandTotal = initialGrandTotal;
        currentUangMuka = {{ $uangMuka }};

        const rowDiskon = document.getElementById('row_diskon');
        if (rowDiskon) rowDiskon.classList.add('hidden');

        document.getElementById('display_grand_total').innerText = "Rp " + formatRupiah(currentGrandTotal);
        document.getElementById('display_dp_nominal').innerText = "Rp " + formatRupiah(currentUangMuka);
        document.getElementById('display_full_nominal').innerText = "Rp " + formatRupiah(currentGrandTotal);

        document.getElementById('input_kode_promo_hidden').value = "";
        document.getElementById('input_grand_total_hidden').value = currentGrandTotal;

        handlePaymentTypeChange();
    }

    function handlePaymentTypeChange() {
        const selectedType = document.querySelector('input[name="payment_type"]:checked').value;
        const labelDp = document.getElementById('label-dp');
        const labelFull = document.getElementById('label-full');
        const badgeNominal = document.getElementById('badge-nominal');
        const infoPembayaran = document.getElementById('info-pembayaran');
        const infoText = document.getElementById('info-text');

        const nominalHarusBayar = (selectedType === 'dp') ? currentUangMuka : currentGrandTotal;
        const nominalSisa = (selectedType === 'dp') ? (currentGrandTotal - currentUangMuka) : 0;

        // Update Input Hidden ke Backend
        document.getElementById('input_nominal_dibayar_hidden').value = nominalHarusBayar;
        document.getElementById('input_sisa_tagihan_hidden').value = nominalSisa;

        if(badgeNominal) {
            badgeNominal.innerText = 'Rp ' + formatRupiah(nominalHarusBayar);
        }

        if (selectedType === 'dp') {
            labelDp.className = "border-2 border-brandRed bg-red-50/30 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all";
            labelDp.querySelector('span:first-of-type').className = "text-xs font-bold text-brandRed tracking-wide uppercase";

            labelFull.className = "border border-gray-200 hover:border-gray-300 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all";
            labelFull.querySelector('span:first-of-type').className = "text-xs font-bold text-gray-400 tracking-wide uppercase";

            infoPembayaran.className = "text-[11px] text-gray-400 bg-amber-50/50 text-amber-700 border border-amber-100 rounded-xl p-3 flex gap-2 items-start transition-all";
            infoText.innerHTML = `Jika memilih opsi <strong>DP 50%</strong>, sisa pelunasan sebesar <strong class="font-harga">Rp ${formatRupiah(nominalSisa)}</strong> dibayarkan saat Anda mengambil produk di toko.`;
        } else {
            labelFull.className = "border-2 border-brandRed bg-red-50/30 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all";
            labelFull.querySelector('span:first-of-type').className = "text-xs font-bold text-brandRed tracking-wide uppercase";

            labelDp.className = "border border-gray-200 hover:border-gray-300 rounded-xl p-4 flex flex-col justify-between cursor-pointer relative overflow-hidden group transition-all";
            labelDp.querySelector('span:first-of-type').className = "text-xs font-bold text-gray-400 tracking-wide uppercase";

            infoPembayaran.className = "text-[11px] text-emerald-700 bg-emerald-50/50 border border-emerald-100 rounded-xl p-3 flex gap-2 items-start transition-all";
            infoText.innerHTML = `Anda memilih opsi <strong>Bayar Lunas (100%)</strong>. Pesanan Anda akan diproses penuh tanpa perlu melakukan pelunasan lagi di toko.`;
        }
    }

    // Function Control Modal Auth Check
    function openAuthModal() {
        document.getElementById('authModal').classList.remove('hidden');
    }

    function closeAuthModal() {
        document.getElementById('authModal').classList.add('hidden');
    }
</script>
@endsection