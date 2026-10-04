<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Mengubah tipe kolom menjadi string agar tidak dibatasi ENUM / panjang karakter yang sempit
            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Opsional: kembalikan ke tipe sebelumnya jika di-rollback
        });
    }
};
