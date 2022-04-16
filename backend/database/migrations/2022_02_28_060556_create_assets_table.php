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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->references('id')->on('asset_categories');
            $table->foreignId('folder_id')->nullable()->references('id')->on('asset_folders');
            $table->string('name');
            $table->string('file')->nullable();
            $table->text('description');
            $table->string('extension')->nullable();
            $table->string('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->dateTimeTz('published_at')->nullable();
            $table->dateTimeTz('expired_at')->nullable();
            $table->boolean('status');
            $table->integer('precedence')->nullable();
            $table->text('dealers')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
