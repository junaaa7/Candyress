<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old table if exists
        Schema::dropIfExists('stocks');

        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('token_or_pin')->nullable();
            $table->text('additional_info')->nullable();
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_stocks');

        // Restore old table (simplified)
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->text('credentials');
            $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });
    }
};
