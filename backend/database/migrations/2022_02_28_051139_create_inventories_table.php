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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->nullable()->references('id')->on('dealers');
            $table->string('dealer_code')->nullable();
            $table->string('dealer_name')->nullable();
            $table->string('variant_code')->nullable();
            $table->foreignId('variant_id')->nullable()->references('id')->on('variants');
            $table->string('model_name')->nullable();
            $table->string('variant_name')->nullable();
            $table->string('model_year')->nullable();
            $table->string('color_name')->nullable();
            $table->string('color_code')->nullable();
            $table->foreignId('color_id')->nullable()->references('id')->on('colors');
            $table->unsignedInteger('quantity')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by_user_id')->nullable()->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
