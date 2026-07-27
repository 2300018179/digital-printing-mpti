<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->text('keterangan')->nullable();
            
            // Kolom baru untuk file & link desain per item
            $table->string('file_desain')->nullable();
            $table->text('link_desain')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu sebelum menghapus tabel
            $table->dropForeign(['pesanan_id']);
            $table->dropForeign(['product_id']);
        });
        
        Schema::dropIfExists('detail_pesanan');
    }
};