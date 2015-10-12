<?php

namespace App\Providers;

use CTLaravel\GoL\Engine;
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
        $this->app->bind('engine', function ($app, $params) {
            $app->configure('ctlaravel');
            return new Engine(
                $app->make(config('ctlaravel.world'), $params),
                $app->make(config('ctlaravel.rules'))
            );
        });
    }

}
