<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Hashing\Hasher;

class DoctrineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app[AuthManager::class]->extend('doctrine_auth', function ($app) {
            return new \App\Extensions\Doctrine\Providers\DoctrineProvider(
                $app[Hasher::class],
                $app['em'],
                $app['config']['auth.model']
            );
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
