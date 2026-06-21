<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk menampilkan semua produk
    public function semuaProduk()
    {
        // Sementara data produk ditaruh di sini (nanti bisa diganti dengan query database seperti Product::all())
        $products = [
            ['title' => 'Banner', 'price' => 'Rp 25.000/m', 'img' => ''],
            ['title' => 'Pamflet', 'price' => 'Rp 5.000/lbr', 'img' => 'assets/products/brosur.png'],
            ['title' => 'Sablon Kaos (1 Warna)', 'price' => 'Rp 15.000/lbr', 'img' => 'assets/products/kaos 1 warna.jpg'],
            ['title' => 'Sablon Jersey (Full Color)', 'price' => 'Rp 10.000/pcs', 'img' => 'assets/products/jersey full color.jpg'],
            ['title' => 'Bendera Full Color', 'price' => 'Rp 35.000/pcs', 'img' => 'assets/products/bendera full color.png'],
            ['title' => 'Kalender Dinding Blangko', 'price' => 'Rp 25.000/pcs', 'img' => 'assets/products/kalender dinding blangko.jpg'],
            ['title' => 'Kalender Dinding Custom', 'price' => 'Rp 35.000/pcs', 'img' => 'assets/products/kalender dinding custome.jpg'],
            ['title' => 'Kalender Meja Premium', 'price' => 'Rp 45.000/pcs', 'img' => 'assets/products/kalender meja.jpg'],
        ];

        // Mengirim data $products ke file semua-produk.blade.php di dalam folder customer
        return view('customer.semua-produk', compact('products'));
    }

    // Method untuk menampilkan detail produk saat diklik
    public function detailProduk()
    {
        // Mengarah ke file detail-produk.blade.php di dalam folder customer
        return view('customer.detail-produk');
    }

    public function halamanPromo()
    {
        // Mengarah ke file promo.blade.php di dalam folder customer
        return view('customer.promo');
    }

    public function jamLayanan()
    {
        // Mengarah ke resources/views/customer/jam-layanan.blade.php
        return view('customer.jam-layanan');
    }
}