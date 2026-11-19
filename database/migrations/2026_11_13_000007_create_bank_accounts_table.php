<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');        // e.g. BCA, BRI, Mandiri, BNI
            $table->string('account_number');   // Nomor Rekening
            $table->string('account_holder');   // Atas Nama (e.g. Batik Gendis Ayu)
            $table->string('qr_code_image')->nullable(); // QRIS image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
