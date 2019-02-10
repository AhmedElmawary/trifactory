<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Answervalues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answervalues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->integer('question_id')->nullable();

            $table->timestamps();
        }); //
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answervalues');

        //
    }
}
