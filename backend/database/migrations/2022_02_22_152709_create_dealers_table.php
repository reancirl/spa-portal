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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->foreignId('group_id')->nullable()->references('id')->on('dealer_groups');
            $table->foreignId('zone_id')->nullable()->references('id')->on('dealer_zones');
            $table->string('email')->nullable();
            $table->text('address_details')->nullable();
            $table->decimal('address_longitude')->nullable();
            $table->decimal('address_latitude')->nullable();
            $table->text('contact_details')->nullable();
            $table->text('bank_details')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_email')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('dealers');
    }
};
