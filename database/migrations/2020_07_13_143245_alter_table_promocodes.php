<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePromocodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'promocodes',
            function (Blueprint $table) {
                $table->json("promo_races")->after("event_id");
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('promocodes', function (Blueprint $table) {
        //     //
        // });
    }
}
