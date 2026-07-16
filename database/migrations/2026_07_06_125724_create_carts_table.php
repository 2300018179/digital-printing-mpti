<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa yang punya keranjang)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Menghubungkan ke tabel products (produk apa yang dimasukkan)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // Jumlah barang yang dibeli
            $table->integer('quantity')->default(1);
            // Catatan khusus cetak (misal: "Laminasi glossy", "Potong sesuai pola")
            $table->text('notes')->nullable();
            
            // --- TAMBAHKAN KOLOM INI UNTUK MENAMPUNG FILE ATAU LINK DESAIN ---
            $table->string('desain')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};