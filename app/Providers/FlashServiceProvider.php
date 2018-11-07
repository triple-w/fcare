<?php

namespace App\Providers;


class FlashServiceProvider extends \Laracasts\Flash\FlashServiceProvider
{    

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        parent::register();

        $this->app->singleton('flash', function () {
            return $this->app->make('App\Extensions\Flash\FlashNotifier');
        });

    }
}
