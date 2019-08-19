<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\NewOrders;
use App\Nova\Metrics\TotalSales;
use App\Nova\Metrics\NewVouchers;
use App\Nova\Metrics\UserRaceCount;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'admin@thetrifactory.com',
                'ayman@thetrifactory.com',
                'beltagy@thetrifactory.com',
                'farida@thetrifactory.com',
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new NewUsers,
            new TotalSales,
            new NewOrders,
            new NewVouchers,
            new UserRaceCount
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Spatie\BackupTool\BackupTool(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
