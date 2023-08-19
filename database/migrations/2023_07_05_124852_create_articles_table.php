<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title', 500);
            $table->string('link')->nullable();
            $table->string('tags', 1000)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('image_type')->comment('0=>image,1=>video')->nullable();
            $table->string('media')->nullable();
            $table->enum('status',['In-Progress','Approved'])->default('In-Progress');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
