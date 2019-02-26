<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_races', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id')->nullable(); //id of orders table
            $table->integer('race_id')->nullable();
            $table->integer('ticket_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('tracker_id')->nullable();

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
        Schema::dropIfExists('user_races');
    }
}
