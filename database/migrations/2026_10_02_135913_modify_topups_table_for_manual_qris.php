<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('payment_method');
            $table->string('proof_image')->nullable()->after('status');
            $table->text('admin_notes')->nullable()->after('proof_image');
        });

        // Copy data from payment_status to status (if needed)
        DB::statement('UPDATE topups SET status = payment_status');

        Schema::table('topups', function (Blueprint $table) {
            $table->dropIndex(['payment_status']);
            $table->dropColumn('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'failed'])->default('pending')->after('payment_method');
            $table->index('payment_status');
        });

        DB::statement("UPDATE topups SET payment_status = status WHERE status IN ('pending', 'paid', 'expired', 'failed')");

        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn(['status', 'proof_image', 'admin_notes']);
        });
    }
};
