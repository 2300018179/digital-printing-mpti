<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                    
                    {{-- Header Customer (Merah Rata Tengah) --}}
                    <tr>
                        <td style="background-color: #c40000; background: linear-gradient(135deg, #c40000 0%, #990000 100%); padding: 30px 25px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1.5px;">
                                Bukti Pembayaran
                            </h1>
                            <p style="color: #ffcccc; font-size: 13px; margin: 5px 0 0 0;">
                                Terima kasih atas pesanan Anda di Fantastic Digital Printing!
                            </p>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 25px;">
                            <p style="color: #333333; font-size: 14px; margin-top: 0;">
                                Halo <strong>{{ $order->nama_pelanggan ?? $order->user->name ?? 'Pelanggan' }}</strong>,
                            </p>
                            <p style="color: #555555; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">
                                Pembayaran untuk transaksi Anda telah kami terima secara berhasil. Berikut adalah rincian tanda terima (E-Receipt) Anda:
                            </p>

                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; font-size: 13px;">
                                <tr>
                                    <td width="40%" style="color: #64748b; font-weight: bold;">No. Transaksi</td>
                                    <td width="60%" style="color: #1e293b; font-weight: bold;">: #{{ $order->order_id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Tanggal Pembayaran</td>
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
                                Rincian Pembelian
                            </h3>
                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px; font-size: 13px;">
                                <thead>
                                    <tr style="background-color: #f1f5f9; color: #475569; text-align: left;">
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px;">Item</th>
                                        <th style="border-bottom: 1px solid #cbd5e1; padding: 8px; text-align: center;">Qty</th>
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
                                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 15px;">Rincian pesanan tidak dapat ditampilkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #1e293b; padding: 8px;">Total Pesanan:</td>
                                        <td style="text-align: right; font-weight: bold; color: #1e293b; padding: 8px;">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #166534; padding: 4px 8px;">Nominal Dibayar ({{ strtoupper($order->tipe_pembayaran ?? 'LUNAS') }}):</td>
                                        <td style="text-align: right; font-weight: bold; color: #166534; font-size: 16px; padding: 4px 8px;">
                                            Rp {{ number_format($order->nominal_dibayar ?? $order->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @if(($order->sisa_pembayaran ?? 0) > 0)
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #d97706; padding: 4px 8px;">Sisa Pelunasan:</td>
                                        <td style="text-align: right; font-weight: bold; color: #d97706; padding: 4px 8px;">
                                            Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>

                            <p style="color: #64748b; font-size: 12px; line-height: 1.4; text-align: center; margin-top: 30px; font-style: italic;">
                                Simpan e-mail ini sebagai bukti pembayaran yang sah. Apabila ada pertanyaan mengenai transaksi ini, silakan hubungi customer service kami.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>