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
        $table->unsignedBigInteger('sub_kategori_id')->nullable(); 
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->integer('price');
        $table->string('unit');
        $table->integer('minimum_order')->default(1); // Kolom minimal order kita aman di sini
        $table->string('image')->nullable();
        $table->enum('status', ['0', '1'])->default('1');
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