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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('activity_source')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('dealer_code')->nullable();
            $table->foreignId('dealer_id')->nullable()->references('id')->on('dealers');
            $table->string('model_name')->nullable();
            $table->string('variant_name')->nullable();
            $table->foreignId('variant_id')->nullable()->references('id')->on('variants');
            $table->dateTime('uploaded_at');
            $table->dateTime('accepted_at');
            $table->string('color')->nullable();
            $table->foreignId('color_id')->nullable()->references('id')->on('colors');
            $table->foreignId('assigned_sc_user_id')->nullable()->references('id')->on('users');
            $table->dateTime('sc_assigned_at')->nullable();
            $table->string('province')->nullable();
            $table->string('barangay')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('municipality')->nullable();
            $table->string('street')->nullable();
            $table->string('preferred_communication')->nullable();
            $table->string('status')->nullable();
            $table->string('action')->nullable();
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
        Schema::dropIfExists('leads');
    }
};
