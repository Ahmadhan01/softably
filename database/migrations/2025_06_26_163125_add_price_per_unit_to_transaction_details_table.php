<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            if (!Schema::hasColumn('transaction_details', 'price_per_unit')) {
                $table->decimal('price_per_unit', 10, 2)->after('quantity');
            }
            if (!Schema::hasColumn('transaction_details', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('price_per_unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            if (Schema::hasColumn('transaction_details', 'price_per_unit')) {
                $table->dropColumn('price_per_unit');
            }
            if (Schema::hasColumn('transaction_details', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};
