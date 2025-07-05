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
        Schema::create('softpay_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., 'topup', 'withdraw', 'purchase', 'transfer_in', 'transfer_out'
            $table->decimal('amount', 15, 2); // Jumlah transaksi (positif untuk masuk, negatif untuk keluar)
            $table->string('description')->nullable();
            $table->string('status')->default('completed'); // 'pending', 'completed', 'failed', 'refunded'
            $table->string('reference_id')->nullable(); // ID transaksi terkait (misal: ID order)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('softpay_transactions');
    }
};