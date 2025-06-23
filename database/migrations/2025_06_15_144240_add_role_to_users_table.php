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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan hanya jika kolom belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'seller', 'customer'])->default('customer');
            }
            // Hapus bagian `username` karena sudah ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop hanya kolom role
            $table->dropColumn('role');
        });
    }
};
