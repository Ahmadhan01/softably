<?php

// database/migrations/YYYY_MM_DD_HHMMSS_add_user_id_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom user_id sebagai foreign key
            // Pastikan ini ditambahkan setelah kolom 'id' atau kolom yang sudah ada
            // Gunakan after() agar sesuai urutan jika penting
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id'); // Hapus foreign key constraint
            $table->dropColumn('user_id'); // Hapus kolom
        });
    }
}