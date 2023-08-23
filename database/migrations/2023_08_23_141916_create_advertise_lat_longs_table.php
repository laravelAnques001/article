<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiseLatLongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertise_lat_longs', function (Blueprint $table) {
            $table->unsignedBigInteger('advertise_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreign('advertise_id')->references('id')->on('advertises')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertise_lat_longs');
    }
}
