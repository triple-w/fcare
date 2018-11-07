<?php

namespace App\Providers;

class BootstrapFormServiceProvider extends \Watson\BootstrapForm\BootstrapFormServiceProvider
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

        $this->app->singleton('bootstrap_form', function($app) {
            return new \App\Extensions\BootstrapForm\BootstrapForm($app['html'], $app['form'], $app['config']);
        });
    }
}
