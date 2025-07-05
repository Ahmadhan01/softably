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
        // Ganti 'soft_pay_transactions' dengan nama tabel lama
        // Ganti 'nama_tabel_baru_anda' dengan nama tabel yang Anda inginkan
        Schema::rename('softpay_transactions', 'soft_pay_transactions'); // Contoh: mengganti nama ke softpay_history
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika rollback, kembalikan nama tabel ke nama sebelumnya
        Schema::rename('soft_pay_transactions', 'softpay_transactions');
    }
};