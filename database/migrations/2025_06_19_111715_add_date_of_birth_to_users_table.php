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
            // Menambahkan kolom 'date_of_birth' sebagai tipe date
            // Bisa nullable jika tidak wajib diisi
            $table->date('date_of_birth')->nullable()->after('phone_number'); // Menempatkan setelah phone_number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'date_of_birth' jika migrasi di-rollback
            $table->dropColumn('date_of_birth');
        });
    }
};  