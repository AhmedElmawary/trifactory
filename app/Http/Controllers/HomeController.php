<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Mail;

use App\Mail\VoucherPurchase;
use App\Mail\SendVoucher;
use App\Events\VoucherPurchased;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::upcomming()->published()->get();
        
        return view('index', ['upcomingEvents' => $upcomingEvents]);
    }

    public function test() {
        // Mail::to('me@me.com')->send(new VoucherPurchase());
        // return (new SendVoucher())->render();
        $meta = new \stdClass();
        $meta->qty = 2;
        $meta->discount_amount = 100;
        $meta->user_email = 'sherief@mail.com';

        event(new VoucherPurchased($meta));
    }
}
