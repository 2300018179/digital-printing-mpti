<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pesanan Baru</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased;">

    <!-- Container Utama Email -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 30px 10px;">
        <tr>
            <td align="center">
                <!-- Card Konten -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner Khas Warna Brand Red (#c40000) -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #c40000 0%, #990000 100%); padding: 30px 25px; text-align: left;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <span style="background-color: #ffffff; color: #c40000; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 8px;">
                                            Perlu Dikonfirmasi
                                        </span>
                                        <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; line-height: 1.3;">
                                            🔔 Order Baru Masuk!
                                        </h1>
                                        <p style="color: #fecdd3; margin: 6px 0 0 0; font-size: 13px;">
                                            No. Pesanan: <strong style="color: #ffffff;">{{ $pesanan->order_id }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Isi Body Email -->
                    <tr>
                        <td style="padding: 25px;">
                            
                            <p style="color: #1e293b; font-size: 15px; margin: 0 0 15px 0; line-height: 1.5;">
                                Halo <strong>Admin</strong>,
                            </p>
                            
                            <p style="color: #475569; font-size: 14px; margin: 0 0 20px 0; line-height: 1.6;">
                                Pelanggan atas nama <strong style="color: #0f172a;">{{ $pesanan->nama_pelanggan }}</strong> telah mengirimkan bukti transfer dan menunggu konfirmasi dari Anda.
                            </p>

                            <!-- Ringkasan Info Singkat Tema Merah Halus -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fff1f2; border: 1px solid #ffe4e6; border-radius: 8px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #9f1239; border-bottom: 1px solid #ffe4e6;">
                                        Waktu Transaksi: <strong style="color: #881337;">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i') }} WIB</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #9f1239;">
                                        Status Saat Ini: <span style="color: #c40000; font-weight: 700;">Menunggu Verifikasi</span>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #1e293b; font-size: 15px; font-weight: 700; margin: 0 0 12px 0;">
                                📦 Rincian Item Pesanan
                            </h3>

                            <!-- Tabel Produk -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                                <thead>
                                    <tr style="background-color: #f8fafc;">
                                        <th style="padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 700; color: #475569; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">Produk</th>
                                        <th style="padding: 10px 12px; text-align: center; font-size: 12px; font-weight: 700; color: #475569; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">Qty</th>
                                        <th style="padding: 10px 12px; text-align: right; font-size: 12px; font-weight: 700; color: #475569; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan->items as $item)
                                    <tr>
                                        <td style="padding: 12px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9;">
                                            <strong>{{ $item->nama_produk }}</strong>
                                            @if($item->keterangan && $item->keterangan !== '-')
                                                <br><small style="color: #64748b;">Note: {{ $item->keterangan }}</small>
                                            @endif
                                        </td>
                                        <td style="padding: 12px; font-size: 13px; color: #334155; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                            {{ $item->jumlah }}
                                        </td>
                                        <td style="padding: 12px; font-size: 13px; color: #0f172a; font-weight: 600; text-align: right; border-bottom: 1px solid #f1f5f9;">
                                            Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Total Pembayaran Warna Merah Brand -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="right">
                                        <p style="margin: 0; font-size: 13px; color: #64748b;">Total Pembayaran:</p>
                                        <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 800; color: #c40000;">
                                            Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Tombol Verifikasi Warna Red-700 / BrandRed (#c40000) -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('admin.pembayaran') }}" target="_blank" style="background-color: #c40000; color: #ffffff !important; display: inline-block; font-size: 14px; font-weight: 700; text-decoration: none; padding: 14px 28px; border-radius: 8px; box-shadow: 0 4px 12px rgba(196, 0, 0, 0.3); border: 1px solid #990000;">
                                            Verifikasi Pesanan Ini &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 15px 25px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                                Email otomatis dikirim oleh Sistem Admin Digital Printing
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>