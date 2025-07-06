<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soft_pay_transactions', function (Blueprint $table) {
            // Hapus atau ganti 'reference_id' jika sudah ada dan tidak digunakan untuk tujuan lain
            // $table->dropColumn('reference_id'); // Jika Anda ingin mengganti namanya
            $table->unsignedBigInteger('transaction_id')->nullable()->after('user_id'); // Tambahkan kolom ini
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null'); // Foreign key
        });
    }

    public function down(): void
    {
        Schema::table('soft_pay_transactions', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropColumn('transaction_id');
            // $table->string('reference_id')->nullable()->after('status'); // Jika Anda menghapusnya di up()
        });
    }
};