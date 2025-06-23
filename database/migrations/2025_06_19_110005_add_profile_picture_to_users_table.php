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
            // Menambahkan kolom 'profile_picture' setelah 'password'
            // Defaultnya bisa null, atau string kosong, atau path ke gambar default
            $table->string('profile_picture')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'profile_picture' jika migrasi di-rollback
            $table->dropColumn('profile_picture');
        });
    }
};