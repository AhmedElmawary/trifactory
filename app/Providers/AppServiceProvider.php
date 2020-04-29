<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\user;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $cart_items = \Cart::getContent()->toArray();
            $user = Auth::user();
            if (!$user) {
                $cart_items = [];
                \Cart::clear();
                \Cart::clearCartConditions();
            }
            $view->with('cart_items_count', count($cart_items));

            $user = Auth::user();
            if ($user) {
                $credit = $user->credit->sum('amount');
                $view->with('credit', $credit);
            }
        });

        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(60),
                ['id' => $notifiable->getKey()]
            );

            // Return your mail here...
            return (new MailMessage)
                ->subject('Verify your email address')
                ->view('emails.verify', ['verifyUrl' => $verifyUrl, 'user' => $notifiable]);
        });
        Schema::defaultStringLength(191);
    }
}
