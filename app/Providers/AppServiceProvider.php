<?php

namespace App\Providers;

use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        if (config('settings.include_language_code')) {
            Config::set('laravellocalization.supportedLocales', get_active_languages());
        }

        if (config('settings.enable_force_ssl')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
