<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Users;

class SetupUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:user_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user admin';

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
        $user = new Users();
        $user->setEmail('jorge.pena@durango.gob.mx');
        $user->setUsername('admin');
        $user->setVerified(true);
        $user->setActive(true);
        $user->setRecovery(false);
        $user->setMustChangePassword(false);
        $user->setRol('ROLE_ADMIN');
        $user->changeHash();
        $user->setPassword('12345678');
        $user->setPermisos(['TIMBRES_TRANSFERENCIA,DOCUMENTOS_POR_APROBAR,USUARIOS,PAGOS_REP_PENDIENTES,PAGOS_REP_TODOS,REPORTE_PAGOS_CONTABILIDAD,REPORTE_PAGOS_TIMBRES,PERIODOS_TERMINADOS,SOLICITUD_PERIODOS,USUARIOS_SIN_DESCARGAS,USUARIOS_CON_DESCARGAS,PLANES_VENCIDOS,FACTURAS_SOLICITADAS']);

        $user->flush();

        $this->info('Usuario admin creado correctamente');
    }
}
