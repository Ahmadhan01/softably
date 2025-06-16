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
            // Tambahkan kolom image_path, bisa nullable jika tidak semua produk punya gambar
            $table->string('image_path')->nullable()->after('price'); // Tambahkan setelah kolom 'price'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image_path'); // Untuk mengembalikan perubahan saat rollback
        });
    }
};