<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_folders', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('precedence')->references('id')->on('asset_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_folders', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
