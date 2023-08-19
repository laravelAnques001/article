<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookmarkToArticleLikeSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_like_shares', function (Blueprint $table) {
           $table->tinyInteger('bookmark')->default(0)->comment('1=bookmark,0=not_bookmark')->after('impressions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_like_shares', function (Blueprint $table) {
            $table->dropColumn('bookmark');
        });
    }
}
