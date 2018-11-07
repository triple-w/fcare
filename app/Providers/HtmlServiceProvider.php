<?php

namespace App\Providers;

class HtmlServiceProvider extends \Collective\Html\HtmlServiceProvider {

	/**
     * Register the form builder instance.
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function($app)
        {
            $form = new \App\Extensions\Html\FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Register the html builder instance.
     */
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function($app)
        {
            return new \App\Extensions\Html\HtmlBuilder($app['url'], $app['view']);
        });
    }


}

?>