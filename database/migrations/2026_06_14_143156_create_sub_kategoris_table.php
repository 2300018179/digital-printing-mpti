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
        Schema::create('sub_kategoris', function (Blueprint $table) {
            $table->id(); // Ini otomatis mewakili kolom 'id' di seeder kamu
            
            // Hubungan foreign key ke tabel kategoris
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            
            $table->string('name'); // Kolom nama sub kategori
            
            // Kolom slug dan timestamps DIBUANG total biar sinkron sama seeder kamu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategoris');
    }
};