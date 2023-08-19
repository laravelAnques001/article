<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('dial_code')->default(91);
            $table->string('mobile_number')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->string('image')->nullable();
            $table->decimal('balance',8,2)->default(0.00);
            $table->string('device_token')->nullable();
            // $table->string('firebase_uid')->nullable();
            // $table->text('firebase_token')->nullable();
            $table->tinyInteger('is_admin')->default(0)->commit('0=Customer, 1=Admin');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
