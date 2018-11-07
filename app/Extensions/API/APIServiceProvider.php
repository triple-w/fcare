<?php

namespace App\Extensions\API;

use Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('API', function(){
            return new API();
        });
    }

}

?>