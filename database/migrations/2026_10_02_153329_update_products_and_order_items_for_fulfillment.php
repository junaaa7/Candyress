<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'login_instructions')) {
                $table->text('login_instructions')->nullable();
            }
            if (! Schema::hasColumn('products', 'duration_label')) {
                $table->string('duration_label')->nullable();
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_stock_id')->nullable()->constrained('product_stocks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_stock_id']);
            $table->dropColumn('product_stock_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['duration_label']);
        });
    }
};
