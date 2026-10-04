<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode promo (contoh: DISKON50)
            $table->enum('discount_type', ['nominal', 'persen'])->default('nominal'); // Tipe diskon
            $table->decimal('discount_value', 15, 2); // Jumlah diskon (Rp atau %)
            $table->date('valid_until')->nullable(); // Batas waktu (expired)
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
