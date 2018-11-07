<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SetupUserAdmin::class,
        \App\Console\Commands\SetupUserAPI::class,
        \App\Extensions\Generator\Generator::class,
        \App\Console\Commands\GenerateEntitiesCommand::class,
        \App\Console\Commands\UpdatePlanesCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:update_planes')->daily()->sendOutputTo('update_planes.log');
    }
}
