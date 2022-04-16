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
        Schema::create('test_drive_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_drive_id')->references('id')->on('test_drives');
            $table->longText('data')->nullable();
            $table->string('status')->nullable();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_drive_histories');
    }
};
