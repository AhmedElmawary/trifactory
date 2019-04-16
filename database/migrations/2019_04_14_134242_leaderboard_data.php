<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaderboardData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaderboard_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('race_id');
            $table->string('bib')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('club')->nullable();
            $table->string('gender')->nullable();
            $table->string('gender_position')->nullable();
            $table->string('category')->nullable();
            $table->string('category_position')->nullable();
            $table->string('country_code')->nullable();
            $table->integer('points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaderboard_data');
    }
}
