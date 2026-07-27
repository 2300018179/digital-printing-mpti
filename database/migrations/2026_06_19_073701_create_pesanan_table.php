<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            // 1. Kolom Relasi User (Wajib Login)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // 2. Data Unik & Identitas Pesanan
            $table->string('order_id')->unique();
            $table->string('nama_pelanggan');
            $table->date('tanggal_pesanan');
            
            // 3. Rincian Biaya & Pembayaran
            $table->decimal('total', 15, 2);
            $table->string('bukti_transfer')->nullable(); // Menampung foto bukti transfer dari customer
            
            // 4. Status Transaksi
            $table->string('status')->default('Menunggu'); // Default awal jika belum terverifikasi
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};