<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_currency', function (Blueprint $table) {
          $table->primary(['user_id','currency_1_id','currency_2_id']);
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('currency_1_id');
          $table->unsignedInteger('currency_2_id');

          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->foreign('currency_1_id')->references('id')->on('currencies')->onDelete('cascade');
          $table->foreign('currency_2_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_currency');
    }
}
