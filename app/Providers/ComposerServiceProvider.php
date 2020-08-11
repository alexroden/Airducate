<?php

namespace App\Providers;

use App\Views\Composers\SiteComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Contracts\View\Factory $factory
     */
    public function boot(Factory $factory): void
    {
        $factory->composer('*', SiteComposer::class);
    }
}
