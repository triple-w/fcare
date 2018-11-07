<?php

namespace App\Extensions\LaravelPNotify;

class NotifyServiceProvider extends \Jleon\LaravelPnotify\NotifyServiceProvider {

	/**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		parent::register();

        $this->app->bind('notify', function()
        {
            return $this->app->make('App\Extensions\LaravelPNotify\Notifier');
        });
    }

}

?>