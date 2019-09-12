<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParticipantTicketIdAndParticipantUserIdToUserRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_races', function (Blueprint $table) {
            $table->string('participant_ticket_id')->nullable()->after('order_id')->default(null);
            $table->integer('participant_user_id')->nullable()->after('participant_ticket_id')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_races', function (Blueprint $table) {
            //
        });
    }
}
