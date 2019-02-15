<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RaceQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_question', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('race_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->integer('order')->nullable();

            $table->timestamps();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('race_question');

        //
    }
}
