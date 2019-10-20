<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Voucher;
use App\Mail\SendWelcomeEmail;
use Mail;

class EmailNewUser
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
        try {
            Mail::to($event->user->email)->send(new SendWelcomeEmail($event->user));
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
