<?php
namespace elsayed85\bank3;

/**
 * Description of KuveytturkServiceProvider.php
 *
 * @author Faruk Çam <mail@farukix.com>
 * Copyright (c) 2018 | farukix.com
 */


use Illuminate\Support\ServiceProvider;
use farukcam\Kuveytturk\Http\Base\Kuveytturk;

class KuveytturkServiceProvider extends ServiceProvider {


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('kuveytturk.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('kuveytturk', function ($app)
        {
            return new Kuveytturk;
        });
    }


}
