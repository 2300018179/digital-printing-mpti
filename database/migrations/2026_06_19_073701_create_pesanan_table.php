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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('order_id')->unique();
            $table->string('nama_pelanggan');
            $table->date('tanggal_pesanan');
            
            // --- RINCIAN BIAYA & PEMBAYARAN (Sudah Disesuaikan) ---
            $table->decimal('total', 15, 2);
            $table->string('tipe_pembayaran', 20)->nullable();
            $table->bigInteger('nominal_dibayar')->default(0);
            $table->string('kode_promo', 50)->nullable();
            $table->bigInteger('diskon')->default(0);
            $table->bigInteger('sisa_pembayaran')->default(0);
            
            $table->string('bukti_transfer')->nullable();
            $table->string('status')->default('Menunggu');
            
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