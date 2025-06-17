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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Terhubung ke user
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Terhubung ke produk
            $table->integer('quantity')->default(1); // Kuantitas produk, default 1
            $table->timestamps();

            // Memastikan user tidak bisa menambahkan produk yang sama berulang kali di keranjang
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};