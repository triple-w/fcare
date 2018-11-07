<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        // realpath(base_path('resources/views_themeforest')),
        // realpath(base_path('resources/views_cleanui')),
        // realpath(base_path('resources/views_limitless_14')),
        realpath(base_path('resources/views_metronic_52')),
    ],

    'paths_theme' => [
        // 'webroot/themes/themeforest-9110062/Templates/default/assets/',
        // 'webroot/themes/clean-ui/cleanui/build/',
        // 'webroot/themes/limitless-14/layout_2/LTR/material/',
        'webroot/themes/metronic-52/dist/demo5/'
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
