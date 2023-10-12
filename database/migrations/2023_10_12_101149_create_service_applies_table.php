<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_applies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('service_applies');
    }
}
