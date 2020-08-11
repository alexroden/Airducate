<?php

namespace App\Providers;

use AltThree\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param \AltThree\Bus\Dispatcher $dispatcher
     */
    public function boot(Dispatcher $dispatcher): void
    {
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, 'App\Bus', 'App\Bus\Handlers');
        });
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
