<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAminitiesBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aminities_businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('aminity_id');
            $table->foreign('business_id')->references('id')->on('businesses')->cascadeOnDelete();
            $table->foreign('aminity_id')->references('id')->on('aminities')->cascadeOnDelete();
            $table->primary(['business_id', 'aminity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aminities_businesses');
    }
}
