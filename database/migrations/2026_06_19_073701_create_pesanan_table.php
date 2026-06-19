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
            Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('nama_pelanggan');
            $table->date('tanggal_pesanan');
            $table->decimal('total', 15, 2);
            $table->string('status'); // Menunggu, Diproses, Dicetak, Dikirim, Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
