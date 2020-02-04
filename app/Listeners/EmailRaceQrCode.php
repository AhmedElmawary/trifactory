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
        $ticket = $event->ticket;
        $self = $event->self;
        $other = $event->other;
        $fromUser = $event->fromUser;
        $newAccount = $event->newAccount;

        if ($participantTicketId != null) {
            try {
                \Mail::to(['address' => $user->email])
                     ->send(new SendQrCodeEmail
                         (
                            $participantTicketId,
                            $user,
                            $ticket,
                            $self,
                            $other,
                            $fromUser,
                            $newAccount
                        )
                     );
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
