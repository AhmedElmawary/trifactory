<?php

namespace App\Providers;

use App\Events\RaceTicketQrCode;
use App\Listeners\EmailRaceQrCode;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\VoucherPurchased;
use App\Events\TicketPurchased;
use App\Events\UserRegistered;

use App\Listeners\CreateUserRace;
use App\Listeners\EmailTicket;
use App\Listeners\CreateVouchers;
use App\Listeners\EmailVoucherBuyer;
use App\Listeners\EmailNewUser;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            EmailNewUser::class,
        ],
        TicketPurchased::class => [
            EmailTicket::class,
            CreateUserRace::class,
        ],
        VoucherPurchased::class => [
            CreateVouchers::class,
            EmailVoucherBuyer::class,
        ],
        RaceTicketQrCode::class => [
          EmailRaceQrCode::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
