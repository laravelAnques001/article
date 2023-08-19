<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->tinyInteger('target')->comment('0=>All,1=>Own')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('redis')->nullable();
            $table->integer('budget')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('status', ['In-Review', 'Publish'])->default('In-Review');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('article_id')->references('id')->on('articles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertises');
    }
}
