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
        Schema::create('products', function (Blueprint $table) {
                $table->id(); // Ini akan membuat kolom 'id' sebagai primary key
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 8, 2); // Harga dengan 8 digit total, 2 di belakang koma
                $table->string('image_path')->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
