<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pelanggan yang mereview
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // Produk yang direview
            $table->integer('rating')->default(5); // Bintang 1-5
            $table->text('comment')->nullable(); // Isi ulasan
            $table->boolean('is_visible')->default(true); // Status tampil/sembunyi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
