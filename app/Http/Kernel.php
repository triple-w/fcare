<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
        'user.validado' => \App\Http\Middleware\UserValidadoMiddleware::class,
        'timbres.disponibles' => \App\Http\Middleware\TimbresDisponiblesMiddleware::class,
        'folios.diff' => \App\Http\Middleware\FoliosDiffMiddleware::class,
        'user.perfil' => \App\Http\Middleware\PerfilMiddleware::class,
        'contabilidad.ciec' => \App\Http\Middleware\CiecMiddleware::class,
        'pagos.contabilidad' => \App\Http\Middleware\ContabilidadMiddleware::class,
        'app.rules' => \App\Http\Middleware\AppRules::class,
        'auth.api' => \App\Http\Middleware\API::class,
        'add.periodo' => \App\Http\Middleware\AddPeriodoMiddleware::class,
        'add.periodo.ciec' => \App\Http\Middleware\AddPeriodoCiecMiddleware::class,
        'perfil.v33' => \App\Http\Middleware\PerfilV33Middleware::class,
    ];
}
