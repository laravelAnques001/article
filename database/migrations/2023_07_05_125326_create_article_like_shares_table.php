<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleLikeSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_like_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('article_id');
            $table->tinyInteger('like')->default(0)->comment('1:Like,0:Unlike');
            $table->tinyInteger('share')->default(0)->comment('1:share,0:Unshare');
            $table->integer('impressions')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('article_like_shares');
    }
}
