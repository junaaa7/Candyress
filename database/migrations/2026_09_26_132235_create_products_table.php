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
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable(); // Harga coret
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('duration')->nullable(); // Contoh: "1 Bulan", "Lifetime"
            $table->string('product_type'); // Contoh: "Shared Account", "Private Account", "License Key"
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('sold')->default(0);
            $table->json('features')->nullable(); // Untuk menyimpan list fitur produk
            $table->text('usage_instructions')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};