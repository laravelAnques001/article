<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->text('device_detail')->nullable();
            $table->tinyInteger('impression')->default(0)->comment('1=impression,0=none');
            $table->tinyInteger('click')->default(0)->comment('1=click,0=none');
            $table->decimal('charge', 8, 2)->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('transactions');
    }
}
