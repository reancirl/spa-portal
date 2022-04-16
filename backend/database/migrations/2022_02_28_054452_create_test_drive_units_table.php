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
        Schema::create('test_drive_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->nullable()->references('id')->on('dealers');
            $table->string('dealer_code')->nullable();
            $table->string('model_name')->nullable();
            $table->string('variant_name')->nullable();
            $table->string('model_year')->nullable();
            $table->string('color_name')->nullable();
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
        Schema::dropIfExists('test_drive_units');
    }
};
