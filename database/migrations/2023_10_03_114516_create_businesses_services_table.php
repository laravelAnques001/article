<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses_services', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('services_id');
            $table->foreign('business_id')->references('id')->on('businesses')->cascadeOnDelete();
            $table->foreign('services_id')->references('id')->on('services')->cascadeOnDelete();
            $table->primary(['business_id', 'services_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses_services');
    }
}
