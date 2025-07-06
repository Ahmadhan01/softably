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
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom sales_count dengan default 0
            $table->unsignedInteger('sales_count')->default(0)->after('status'); // Atau setelah kolom lain yang relevan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('sales_count');
        });
    }
};