<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;
use App\user;

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
            $view->with('cart_items_count', count($cart_items));

            $user = Auth::user();
            if($user)
            {
                $credit = $user->credit->sum('amount');
                $view->with('credit', $credit);
            }
        });
    }
}
