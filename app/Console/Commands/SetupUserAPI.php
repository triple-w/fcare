<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupUserAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:user_api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar usuario para API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = new \App\Models\UsersAPI();
        $user->setUsername('admin');
        $user->setActive(true);
        $user->setRol('ROLE_ADMIN');
        $user->changeToken();

        $user->flush();

        $this->info('Usuario API admin creado correctamente');
    }
}
