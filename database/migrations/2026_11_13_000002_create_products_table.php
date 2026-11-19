<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('motif')->nullable();       // e.g. Parang Rusak, Mega Mendung, Kawung, Sekar Jagad
            $table->string('material')->nullable();    // e.g. Katun Primisima, Sutra ATBM, Mori Halus
            $table->string('technique')->nullable();   // e.g. Batik Tulis Halus, Batik Cap, Kombinasi
            $table->decimal('buy_price', 12, 2)->default(0); // Harga Beli / HPP untuk valuasi persediaan
            $table->decimal('price', 12, 2);           // Harga Jual ke Konsumen
            $table->integer('weight')->default(350);    // Berat dalam gram untuk hitung ongkir
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('min_stock')->default(5);  // Safety Stock / Ambang batas stok kritis
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
