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
        Schema::create('premium_accounts', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel products (menandakan stok ini milik paket produk apa)
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            // Kredensial akun premium yang akan dijual
            $table->string('email');
            $table->string('password'); 
            
            // Status ketersediaan akun
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_accounts');
    }
};