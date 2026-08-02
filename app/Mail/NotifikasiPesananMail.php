<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiPesananMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pesanan;
    public $tipe;

    public function __construct($pesanan, $tipe = 'struk_pelanggan')
    {
        $this->pesanan = $pesanan;
        $this->tipe = $tipe;
    }

    public function build()
    {
        if ($this->tipe === 'notif_admin') {
            return $this->subject('Pesanan Baru Masuk - ' . $this->pesanan->order_id)
                        ->view('emails.pesanan_baru_admin')
                        ->with(['order' => $this->pesanan]); 
        }

        return $this->subject('Struk Pembayaran - ' . $this->pesanan->order_id)
                    ->view('emails.struk_pembayaran')
                    ->with(['order' => $this->pesanan]); 
    }
}