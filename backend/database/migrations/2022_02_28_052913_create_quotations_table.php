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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('dealer_id')->nullable()->references('id')->on('dealers');
            $table->string('dealer_name')->nullable();
            $table->string('model_name')->nullable();
            $table->foreignId('variant_id')->nullable()->references('id')->on('variants');
            $table->string('variant_name')->nullable();
            $table->string('color_name')->nullable();
            $table->foreignId('color_id')->nullable()->references('id')->on('colors');
            $table->foreignId('assigned_sc_user_id')->nullable()->references('id')->on('users');
            $table->dateTime('sc_assigned_at')->nullable();
            $table->string('status')->nullable();
            $table->string('action')->nullable();
            $table->string('source')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by_user_id')->nullable()->references('id')->on('users');
            $table->string('document')->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
