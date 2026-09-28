<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('Candyress');
            $table->string('logo')->nullable(); // Path gambar logo
            $table->string('whatsapp')->nullable(); // Nomor WA Admin
            $table->string('email')->nullable(); // Email toko
            $table->text('bank_account')->nullable(); // Detail rekening (BCA, Mandiri, dll)
            $table->string('qris_image')->nullable(); // Path gambar barcode QRIS
            $table->text('store_info')->nullable(); // Deskripsi singkat / Aturan toko
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};