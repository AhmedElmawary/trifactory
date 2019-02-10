<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Voucher;
use App\Mail\SendVoucher;
use Mail;

class CreateVouchers
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
        for($i=0;$i<$event->meta->qty;$i++)
        {
            $voucher = new Voucher();
            $voucher->code = uniqid('V');
            $voucher->user_email = $event->meta->user_email;
            $voucher->save();

            Mail::to('reciever@tf.com')->send(new SendVoucher());
        }
    }
}
