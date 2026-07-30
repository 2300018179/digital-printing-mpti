<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 30px 25px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1.5px;">
                                Bukti Pembayaran
                            </h1>
                            <p style="color: #94a3b8; font-size: 13px; margin: 5px 0 0 0;">
                                Terima kasih atas pesanan Anda!
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 25px;">
                            <p style="color: #333333; font-size: 14px; margin-top: 0;">
                                Halo <strong>{{ $order->user->name ?? 'Pelanggan Setia' }}</strong>,
                            </p>
                            <p style="color: #555555; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">
                                Pembayaran untuk transaksi Anda telah kami terima secara berhasil. Berikut adalah rincian tanda terima (E-Receipt) Anda:
                            </p>

                            <!-- Receipt Meta Info -->
                            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; font-size: 13px;">
                                <tr>
                                    <td width="40%" style="color: #64748b; font-weight: bold;">No. Transaksi</td>
                                    <td width="60%" style="color: #1e293b; font-weight: bold;">: {{ $order->transaction_code ?? $order->id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Tanggal Pembayaran</td>
                                    <td style="color: #1e293b;">: {{ \Carbon\Carbon::parse($order->updated_at ?? $order->created_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Metode Pembayaran</td>
                                    <td style="color: #1e293b;">: {{ strtoupper($order->payment_method ?? 'Midtrans / Online') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: bold;">Status Transaksi</td>
                                    <td style="color: #1e293b;">
                                        <span style="background-color: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px; display: inline-block;">
                                            BERHASIL / LUNAS
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- Item List Header -->
                            <h3 style="color: #1e293b; font-size: 15px; margin: 0 0 10px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 5px;">
                                Rincian Pembelian
                            </h3>

                            <!-- Item List Table -->
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
                                    @if(isset($order->items) && count($order->items) > 0)
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px;">
                                                {{ $item->product->name ?? $item->product_name }}
                                            </td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: center;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: right;">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td style="border-bottom: 1px solid #e2e8f0; color: #334155; padding: 8px; text-align: right;">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 15px;">
                                                Rincian pesanan tidak dapat ditampilkan.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold; color: #1e293b; padding: 12px 8px 5px 8px;">Total Bayar:</td>
                                        <td style="text-align: right; font-weight: bold; color: #166534; font-size: 16px; padding: 12px 8px 5px 8px;">
                                            Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <p style="color: #64748b; font-size: 12px; line-height: 1.4; text-align: center; margin-top: 30px; font-style: italic;">
                                Simpan e-mail ini sebagai bukti pembayaran yang sah. Apabila ada pertanyaan mengenai transaksi ini, silakan hubungi tim layanan pelanggan kami.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 15px 25px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Store Name. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>