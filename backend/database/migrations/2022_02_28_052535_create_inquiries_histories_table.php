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
        Schema::create('inquiries_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->nullable()->references('id')->on('inquiries');
            $table->longText('data')->nullable();
            $table->string('status')->nullable();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('updated_by_user_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries_histories');
    }
};
