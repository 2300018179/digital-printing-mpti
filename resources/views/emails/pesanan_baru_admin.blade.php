<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pesanan Baru</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                    
                    {{-- Header Admin (Rata Tengah) --}}
                    <tr>
                        <td style="background-color: #c40000; background: linear-gradient(135deg, #c40000 0%, #990000 100%); padding: 30px 25px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px;">
                                Notifikasi Pesanan Baru
                            </h1>
                            <p style="color: #ffcccc; font-size: 13px; margin: 5px 0 0 0;">
                                Ada transaksi baru yang membutuhkan perhatian Anda.
                            </p>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 25px;">
                            <p style="color: #333333; font-size: 14px; margin-top: 0;">Halo <strong>Admin</strong>,</p>
                            <p style="color: #555555; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">
                                Sistem telah menerima pesanan baru dari pelanggan. Berikut adalah rincian transaksinya:
                            </p>

                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; font-size: 13px;">
                                <tr>
                                    <td width="35%" style="color: #64748b; font-weight: bold;">Kode Transaksi</td>
                                    <td width="65%" style="color: #1e293b; font-weight: bold;">: #{{ $order->order_id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Nama Pelanggan</td>
                                    <td style="color: #1e293b;">: {{ $order->nama_pelanggan ?? $order->user->name ?? 'Pelanggan' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Email Pelanggan</td>
                                    <td style="color: #1e293b;">: {{ $order->user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Tanggal Transaksi</td>
                                    <td style="color: #1e293b;">: {{ \Carbon\Carbon::parse($order->tanggal_pesanan ?? $order->created_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Tipe Pembayaran</td>
                                    <td style="color: #1e293b;">
                                        <span style="background-color: {{ strtolower($order->tipe_pembayaran) == 'dp' ? '#fef3c7' : '#dcfce7' }}; color: {{ strtolower($order->tipe_pembayaran) == 'dp' ? '#92400e' : '#166534' }}; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;">
                                            {{ strtoupper($order->tipe_pembayaran ?? 'LUNAS') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #1e293b; font-size: 15px; margin: 0 0 10px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 5px;">
                                Item yang Dipesan
                            </h3>
                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px; font-size: 13px;">
                                <thead>
                                    <tr style="background-color: #f1f5f9; color: #475569; text-align: left;">
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px;">Produk</th>
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px; text-align: center;">Jumlah</th>
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px; text-align: right;">Harga</th>
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px; text-align: right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $items = $order->detailPesanan ?? $order->items ?? []; @endphp
                                    @forelse($items as $item)
                                        @php
                                            $namaProduk = $item->nama_produk ?? $item->product->name ?? 'Produk';
                                            $jumlah = $item->jumlah ?? $item->quantity ?? 1;
                                            $harga = $item->harga ?? $item->price ?? 0;
                                        @endphp
                                        <tr>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px;">{{ $namaProduk }}</td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: center;">{{ $jumlah }}</td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: right;">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: right;">Rp {{ number_format($harga * $jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 15px;">Rincian produk tidak tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #1e293b; padding: 8px;">Grand Total Pesanan:</td>
                                        <td style="text-align: right; font-weight: bold; color: #1e293b; padding: 8px;">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #c40000; padding: 4px 8px;">Nominal Dibayar ({{ strtoupper($order->tipe_pembayaran ?? 'LUNAS') }}):</td>
                                        <td style="text-align: right; font-weight: bold; color: #c40000; font-size: 15px; padding: 4px 8px;">
                                            Rp {{ number_format($order->nominal_dibayar ?? $order->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @if(($order->sisa_pembayaran ?? 0) > 0)
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #d97706; padding: 4px 8px;">Sisa Tagihan (DP):</td>
                                        <td style="text-align: right; font-weight: bold; color: #d97706; padding: 4px 8px;">
                                            Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 25px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/admin/pesanan') }}" style="background-color: #c40000; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; font-size: 14px; display: inline-block;">
                                            Buka Dashboard Admin
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>