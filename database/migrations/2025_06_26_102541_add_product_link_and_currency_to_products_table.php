// database/migrations/202X_XX_XX_XXXXXX_add_product_link_and_currency_to_products_table.php

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
            // Tambahkan kolom product_link (setelah image_path, misalnya)
            $table->string('product_link')->nullable()->after('image_path');
            // Tambahkan kolom currency (setelah price, misalnya)
            $table->string('currency', 10)->default('IDR')->after('price'); // varchar(10), default IDR
            // Untuk category, pastikan kolom 'category' sudah ada. Jika kategori bisa banyak,
            // Anda mungkin ingin menyimpannya sebagai JSON atau string dipisahkan koma.
            // Contoh untuk JSON: $table->json('category')->nullable();
            // Jika sudah ada 'category' varchar/string, itu bisa digunakan untuk menyimpan string dipisahkan koma.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_link');
            $table->dropColumn('currency');
        });
    }
};