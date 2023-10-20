<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlanPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plan_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id');
            $table->unsignedBigInteger('business_id');
            $table->text('payment_response');
            $table->string('transaction_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->cascadeOnDelete();
            $table->foreign('business_id')->references('id')->on('businesses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plan_purchases');
    }
}
