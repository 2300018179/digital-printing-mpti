<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Pesanan
        $pesanan = \App\Models\Pesanan::create([
            'order_id' => 'ORD-001',
            'nama_pelanggan' => 'Budi Santoso',
            'total' => 350000,
            'status' => 'Menunggu',
            'alamat' => 'Jl. Merdeka No. 123',
            'no_hp' => '08123456789'
        ]);

        // 2. Buat Detail Pesanan (PENTING: Gunakan $pesanan->id agar sinkron)
        \App\Models\DetailPesanan::create([
            'pesanan_id' => $pesanan->id, 
            'nama_produk' => 'Spanduk Digital',
            'harga' => 175000,
            'jumlah' => 2,
            'keterangan' => 'Bahan Flexi 280gr'
        ]);
    }
}
