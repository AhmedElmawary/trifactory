<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Voucher;
use App\User;
use App\Mail\SendVoucher;
use Auth;
use Illuminate\Support\Facades\Mail;
use Hash;

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
        for ($i=0; $i<$event->meta->qty; $i++) {
            $user = User::where('email', $event->meta->recipient_email)->first();
            if (!$user) {
                $newAccount = true;
                $name = explode(" ", $event->meta->recipient_name);
                
                if (count($name) === 1) {
                    $name[1] = '';
                }

                $user = User::create([
                    'name' => $event->meta->recipient_name,
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'email' => $event->meta->recipient_email,
                    'phone' => $event->meta->recipient_phone,
                    'password' => Hash::make(uniqid('TFP')),
                ]);
            }

            $voucher = new Voucher();
            $voucher->code = uniqid('TFV');
            $voucher->amount = $event->meta->discount_amount;
            $voucher->user_id = $user->id;
            $voucher->sender_id = $event->user->id;
            $voucher->save();

            try {
                Mail::to($event->meta->recipient_email)->send(new SendVoucher($event->meta, $event->user, $voucher));
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
