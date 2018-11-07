<?php

namespace App\Extensions\Bootstrapper;


class BootstrapperL5ServiceProvider extends \Bootstrapper\BootstrapperL5ServiceProvider {

	public function register()
    {
        parent::register();

        $this->registerNavigation();
        $this->registerCarousel();
        
    }

	/**
     * Registers the Navigation class into the IoC
     */
    private function registerNavigation()
    {
        $this->app->bind(
            'bootstrapper::navigation',
            function ($app) {
                 return new Navigation($app->make('url'));
            }
        );
    }

    /**
     * Registers the Carousel class into the IoC
     */
    private function registerCarousel()
    {
        $this->app->bind(
            'bootstrapper::carousel',
            function () {
                return new Carousel;
            }
        );
    }

}

?>