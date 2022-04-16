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
        Schema::create('variant_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->nullable()->references('id')->on('variants');
            $table->foreignId('color_id')->nullable()->references('id')->on('colors');
            $table->string('name');
            $table->double('price', 10, 2)->nullable();
            $table->string('pricing')->nullable();
            $table->string('code')->nullable();
            $table->string('long_name')->nullable();
            $table->boolean('status');
            $table->foreignId('created_by_user_id')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by_user_id')->nullable()->references('id')->on('users');
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
        Schema::dropIfExists('variant_colors');
    }
};
