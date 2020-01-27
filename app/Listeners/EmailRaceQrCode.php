<?php

namespace App\Listeners;

use App\Mail\SendQrCodeEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailRaceQrCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $participantTicketId = $event->participantTicketId;
        $user = $event->user;
        $race = $event->race;
        $event4race = $event->event;
        if($participantTicketId != null)
        {
            try {

                \Mail::to(['address' => $user->email])->send(new SendQrCodeEmail($participantTicketId, $user, $race, $event4race));

            } catch (\Exception $e) {
                \App\Exception::create([
                    'message' => $e->getMessage(),
                    'data' => json_encode($event),
                    'location' =>
                        'Line:'.__LINE__
                        .';File:'.__FILE__
                        .';Class:'.__CLASS__
                        .';Method:'.__METHOD__
                ]);
            }
        }
    }
}
