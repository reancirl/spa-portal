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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->nullable()->references('id')->on('models');
            $table->foreignId('year_id')->nullable()->references('id')->on('model_years');
            $table->string('name');
            $table->string('alias');
            $table->string('long_name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->double('price', 10, 2)->nullable();
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
        Schema::dropIfExists('variants');
    }
};
