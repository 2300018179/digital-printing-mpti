<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Pesanan</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased;">

    <!-- Container Utama Email -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 30px 10px;">
        <tr>
            <td align="center">
                <!-- Card Konten -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner Warna Brand Red (#c40000) -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #c40000 0%, #990000 100%); padding: 30px 25px; text-align: left;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <span style="background-color: #ffffff; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 8px;">
                                            Pembayaran Diterima
                                        </span>
                                        <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; line-height: 1.3;">
                                            🧾 Bukti Pembayaran / Struk
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
                                Halo <strong>{{ $pesanan->nama_pelanggan }}</strong>,
                            </p>
                            
                            <p style="color: #475569; font-size: 14px; margin: 0 0 20px 0; line-height: 1.6;">
                                Terima kasih! Pembayaran untuk pesanan Anda telah kami konfirmasi dan saat ini pesanan Anda sedang dalam status: <strong style="color: #16a34a;">{{ $pesanan->status }}</strong>.
                            </p>

                            <!-- Ringkasan Info Pesanan -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #166534; border-bottom: 1px solid #bbf7d0;">
                                        Tanggal Pesanan: <strong style="color: #14532d;">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i') }} WIB</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #166534;">
                                        Status Pesanan: <span style="color: #16a34a; font-weight: 700;">{{ $pesanan->status }}</span>
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
                                        <th style="padding: 10px 12px; text-align: right; font-size: 12px; font-weight: 700; color: #475569; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">Harga Subtotal</th>
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

                            <!-- Tombol Cek Pesanan Saya (BrandRed #c40000) -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('customer.pesanan-saya') }}" target="_blank" style="background-color: #c40000; color: #ffffff !important; display: inline-block; font-size: 14px; font-weight: 700; text-decoration: none; padding: 14px 28px; border-radius: 8px; box-shadow: 0 4px 12px rgba(196, 0, 0, 0.3); border: 1px solid #990000;">
                                            Lihat Pesanan Saya &rarr;
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
                                Pesan ini dikirim secara otomatis oleh Sistem Digital Printing.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>