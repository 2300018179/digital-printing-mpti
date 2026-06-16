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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('slug')->unique(); 
            $table->string('kategori'); // Tambahan untuk kategori produk
            $table->text('description')->nullable(); 
            $table->integer('price'); 
            $table->integer('stock')->default(0); // Tambahan untuk stok
            $table->string('unit'); // Satuan produk (m², lembar, box)
            $table->string('image')->nullable(); 
            $table->string('status')->default('Aktif'); // Tambahan untuk status produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
