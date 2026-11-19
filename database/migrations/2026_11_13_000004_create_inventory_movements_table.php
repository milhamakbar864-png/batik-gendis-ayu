<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->enum('type', ['in', 'out', 'sale', 'adjustment']);
            $table->string('reference_type')->nullable(); // 'order', 'supplier_purchase', 'stock_opname', 'damage_loss'
            $table->string('reference_number')->nullable();
            $table->integer('quantity');                  // Jumlah mutasi (misal +10 atau -2)
            $table->integer('stock_before');              // Stok sebelum mutasi
            $table->integer('stock_after');               // Stok sesudah mutasi
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
