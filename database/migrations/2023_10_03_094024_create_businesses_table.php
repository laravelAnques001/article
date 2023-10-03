<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name');
            $table->string('gst_number')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->year('year')->nullable();
            $table->time('time')->nullable();
            $table->string('amenities')->nullable();
            $table->string('website')->nullable();
            $table->text('people_search')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Deactive'])->default('Active');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
