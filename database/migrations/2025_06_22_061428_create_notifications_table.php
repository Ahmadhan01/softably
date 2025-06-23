<?php

// database/migrations/xxxx_xx_xx_create_notifications_table.php
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Penerima notifikasi
            $table->string('type'); // transaction, chat, promo, system, dll.
            $table->string('title'); // Judul notifikasi, ex: "Transaction Successful"
            $table->text('message'); // Isi notifikasi
            $table->json('data')->nullable(); // Data tambahan (ex: product_id, chat_id, transaction_id)
            $table->boolean('is_read')->default(false); // Status sudah dibaca/belum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
