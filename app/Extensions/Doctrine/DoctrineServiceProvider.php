<?php

namespace App\Extensions\Doctrine;

// use LaravelDoctrine\ORM\Auth\DoctrineUserProvider;
use App\Extension\Doctrine\Auth\DoctrineUserProvider;

class DoctrineServiceProvider extends \LaravelDoctrine\ORM\DoctrineServiceProvider {

	
	protected function extendAuthManager() {
		$this->app->make('auth')->provider('doctrine', function ($app) {
            $defaultDriver = $this->app['config']['auth.defaults.guard'];
            $provider = $this->app['config']["auth.guards.{$defaultDriver}"]['provider'];
            $entity = $app->make('config')->get("auth.providers.{$provider}.model");

            return new \App\Extensions\Doctrine\Auth\DoctrineUserProvider(
                $app['hash'],
                $app['em'],
                $entity
            );
        });
	}

}

?>