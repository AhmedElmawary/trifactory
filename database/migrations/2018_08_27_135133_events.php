<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  Schema::create('events', function (Blueprint $table) {
        $table->increments('id');
        $table->string('city');
        $table->string('country');
        $table->string('name');
        $table->longText('details')->nullable();
        $table->string('address');
        $table->string('published');

        $table->date('event_start')->nullable();
        $table->date('event_end')->nullable();

        $table->timestamps();
    });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');

        //
    }
}
