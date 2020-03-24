<?php

namespace elsayed85\bank3;

/**
 * Description of TurkeyBankServiceProvider.php
 *
 * @author Faruk Çam <mail@farukix.com>
 * Copyright (c) 2018 | farukix.com
 */

use elsayed85\bank3\Http\Base\TurkeyBank;
use Illuminate\Support\ServiceProvider;

class TurkeyBankServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('TurkeyBank.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('TurkeyBank', function ($app) {
            return new TurkeyBank;
        });
    }
}
