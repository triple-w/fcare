<?php

namespace App\Extensions\MultiPac;

use Illuminate\Support\ServiceProvider;

class MultiPacServiceProvider extends ServiceProvider {

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
        $this->app->bind('MultiPac', function(){
            return new MultiPac();
        });
    }

}

?>