<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->unsignedBigInteger('clicks')->default(0)->after('url');
        });
    }

    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('clicks');
        });
    }
};
