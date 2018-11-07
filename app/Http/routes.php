<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//API ROUTES
Route::group([ 'prefix' => 'api/v1', 'middleware' => [ 'auth.api' ] ], function() {
    Route::controllers([
        'users' => 'API\v1\Users\Accounts'
    ]);
});

//APIUsers ROUTES
Route::group([ 'prefix' => 'apiusers/v1', 'middleware' => [ 'auth.apiusers' ] ], function() {
    Route::controllers([
        'facturas' => 'APIUsers\v1\Users\FacturasController',
        'complementos' => 'APIUsers\v1\Users\ComplementosController',
    ]);
});

//APP ROUTES
Route::get('/', 'Auth\AuthController@getLogin');
Route::get('/login', 'Auth\AuthController@getLogin');
//Route::get('/pagos-timbres/pagomp','Pagos\TimbresController@getPagoMp');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'users' => 'Users\AccountsController',
    'webhooks' => 'WebHooks\WebHooksController',
]);

//ROUTES APP AUTENTIFICATED
Route::group([ 'middleware' => [ 'auth', 'app.rules' ] ], function() {

    Route::controllers([
        'dashboard' => 'Users\DashboardController',
        'clientes' => 'Users\ClientesController',
        'empleados' => 'Users\EmpleadosController',
        'productos' => 'Users\ProductosController',
        'facturas' => 'Users\FacturasV33Controller',
        'facturas-complementos' => 'Users\FacturasV33ComplementosController',
        'nominas' => 'Users\NominasController',
        'impuestos' => 'Users\ImpuestosController',
        'reportes' => 'Users\ReportesController',
        'reportes-admin' => 'Users\ReportesAdminController',
        'timbres' => 'Timbres\TimbresController',
        'folios' => 'Users\FoliosController',
        'periodos' => 'Users\PeriodosController',
        'periodos-movimientos' => 'Users\PeriodosMovimientosController',
        'periodos-movimientos-propuestas' => 'Users\PeriodosMovimientosPropuestasController',
        'reportar-pago' => 'Users\ReportarPagosController',
        'pagos-timbres' => 'Pagos\TimbresController',
        'pagos-reportados' => 'ReportarPagos\ReportarPagosController',
        'pagos-contabilidad' => 'Pagos\ContabilidadController',
        'periodos-terminados' => 'PeriodosTerminados\PeriodosTerminadosController',
        'solicitudes-periodos' => 'SolicitudesPeriodos\SolicitudesPeriodosController',
        'complementos' => 'Users\ComplementosV33Controller',
        'emails' => 'Users\EmailPController',
        'plantillas' => 'Users\PlantillasController',
    ]);

});
