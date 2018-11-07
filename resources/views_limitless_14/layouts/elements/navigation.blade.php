<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="category-content">
                <div class="sidebar-user-material-content">
                    @set('image', HTML::image('webroot/img/logo02.png', 'User', [ 'class' => 'img-circle img-responsive' ]))
                    @if (!empty(Auth::user()->getLogo()))
                        @set("logo", Auth::user()->getLogo()->getName())
                        @set('image', HTML::image("uploads/users_logos/{$logo}", 'User', [ 'class' => 'img-circle img-responsive' ]))
                    @endif
                    <a href="#">
                        {!! $image !!}
                    </a>
                    <h6>{{ Auth::user()->getUsername() }}</h6>
                    <!-- <span class="text&#45;size&#45;small">Santa Ana, CA</span> -->
                </div>

                <div class="sidebar-user-material-menu">
                    <a href="#user-nav" data-toggle="collapse"><span>Perfil</span> <i class="caret"></i></a>
                </div>
            </div>

            <div class="navigation-wrapper collapse" id="user-nav">
                <ul class="navigation">
                    <li><a href="{{ action('Users\AccountsController@getPerfil') }}"><i class="icon-user-plus"></i> <span>Información</span></a></li>
                    <li><a href="{{ action('Users\AccountsController@getChangePassword') }}"><i class="icon-coins"></i> <span>Cambiar Password</span></a></li>
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        <li><a href="{{ action('Users\AccountsController@getDatos') }}"><i class="icon-comment-discussion"></i> <span>Subir Sello Digital</span></a></li>
                    @endif
                    <li class="divider"></li>
                    <li><a href="{{ action('Auth\AuthController@getLogout') }}"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <li class="navigation-header"><span>Facturacion</span> <i class="icon-menu" title="Facturacion"></i></li>
                    <li class="active"><a href="{{ action('Users\DashboardController@getIndex') }}"><i class="icon-home4"></i> <span>Inicio</span></a></li>
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        @if (Auth::user()->checkAccess('TIMBRES_TRANSFERENCIA'))
                            <li>
                                <a href="#"><i class="icon-stack2"></i> <span>Timbres</span></a>
                                <ul>
                                    <!-- <li><a href="{{ action('Timbres\TimbresController@getAdd') }}">Agregar</a></li> -->
                                    <li><a href="{{ action('Timbres\TimbresController@getTransferencia') }}">Transferencia</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        @if (Auth::user()->checkAccess('DOCUMENTOS_POR_APROBAR'))
                            <li><a href="{{ action('Users\AccountsController@getDocumentosAprobar') }}"><i class="icon-folder-search"></i> <span>Documentos por Aprobar</span></a></li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        @if (Auth::user()->checkAccess('USUARIOS'))
                            <li><a href="{{ action('Users\AccountsController@getIndex') }}"><i class="icon-users"></i> <span>Usuarios</span></a></li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        <li>
                            <a href="#"><i class="icon-folder4"></i> <span>Pagos Reportados</span></a>
                            <ul>
                                @if (Auth::user()->checkAccess('PAGOS_REP_PENDIENTES'))
                                    <li><a href="{{ action('ReportarPagos\ReportarPagosController@getIndexPendientes') }}">Pendientes</a></li>
                                @endif
                                @if (Auth::user()->checkAccess('PAGOS_REP_TODOS'))
                                    <li><a href="{{ action('ReportarPagos\ReportarPagosController@getIndex') }}">Todos</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        <li>
                            <a href="#"><i class="icon-folder4"></i> <span>Reporte de Pagos</span></a>
                            <ul>
                                @if (Auth::user()->checkAccess('REPORTE_PAGOS_CONTABILIDAD'))
                                    <li><a href="{{ action('Users\ReportesAdminController@getPagosContabilidad') }}">Contabilidad</a></li>
                                @endif
                                @if (Auth::user()->checkAccess('REPORTE_PAGOS_TIMBRES'))
                                    <li><a href="{{ action('Users\ReportesAdminController@getPagosTimbres') }}">Timbres</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        @if (Auth::user()->isComplete())
                            <li>
                                <a href="#"><i class="icon-stack2"></i> <span>Catalogos</span></a>
                                <ul>
                                    <li><a href="{{ action('Users\ClientesController@getIndex') }}">Clientes</a></li>
                                    <li><a href="{{ action('Users\ProductosController@getIndex') }}">Productos</a></li>
                                    <li><a href="{{ action('Users\ImpuestosController@getIndex') }}">Impuestos</a></li>
                                    <li><a href="{{ action('Users\EmpleadosController@getIndex') }}">Empleados</a></li>
                                    <li><a href="{{ action('Users\FoliosController@getIndex') }}">Folios</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        @if (Auth::user()->isComplete())
                            <li>
                                <a href="#"><i class="icon-file-text2"></i> <span>Facturas/CFDI's</span></a>
                                <ul>
                                    <li><a href="{{ action('Users\FacturasV33Controller@getIndex') }}">Facturas</a></li>
                                    <li><a href="{{ action('Users\NominasController@getIndex') }}">Nominas</a></li>
                                    <li><a href="{{ action('Users\ComplementosV33Controller@getIndex') }}">Complementos de Pago</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        <li>
                            <a href="#"><i class="icon-folder4"></i> <span>Comprar Timbres</span></a>
                            <ul>
                                <li><a href="{{ action('Pagos\TimbresController@getPago') }}">Pago con Tarjeta</a></li>
                                <li><a href="{{ action('Users\ReportarPagosController@getIndex') }}">Deposito o Transferencia</a></li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        @if (Auth::user()->isComplete())
                            <li>
                                <a href="#"><i class="icon-file-stats"></i> <span>Reportes</span></a>
                                <ul>
                                    <li><a href="{{ action('Users\ReportesController@getFacturas') }}">Facturas</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    <li class="navigation-header"><span>Contabilidad</span> <i class="icon-menu" title="Contabilidad"></i></li>
                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                        @if (Auth::user()->checkAccess('PERIODOS_TERMINADOS'))
                            <li><a href="{{ action('PeriodosTerminados\PeriodosTerminadosController@getIndex') }}"><i class="icon-users"></i> <span>Periodos Terminados</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('SOLICITUD_PERIODOS'))
                            <li><a href="{{ action('SolicitudesPeriodos\SolicitudesPeriodosController@getIndex') }}"><i class="icon-users"></i> <span>Solicitud Periodos</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('USUARIOS_SIN_DESCARGAS'))
                            <li><a href="{{ action('Users\AccountsController@getUsersNoContabilidad') }}"><i class="icon-users"></i> <span>Usuarios sin descargas Disponibles</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('USUARIOS_CON_DESCARGAS'))
                            <li><a href="{{ action('Users\AccountsController@getUsersContabilidad') }}"><i class="icon-users"></i> <span>Usuarios con descargas Disponibles</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('PLANES_VENCIDOS'))
                            <li><a href="{{ action('Users\ReportesAdminController@getPlanesVencidos') }}"><i class="icon-users"></i> <span>Planes Vencidos</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('FACTURAS_SOLICITADAS'))
                            <li><a href="{{ action('Users\ReportesAdminController@getFacturasPendientes') }}"><i class="icon-users"></i> <span>Facturas Solicitadas</span></a></li>
                        @endif
                        @if (Auth::user()->checkAccess('VERIFICAR_CIEC'))
                            <li><a href="{{ action('Users\AccountsController@getVerificarCiec') }}"><i class="icon-users"></i> <span>Verificar CIEC</span></a></li>
                        @endif
                    @endif
                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        <li>
                            <a href="{{ action('Pagos\ContabilidadController@getPago') }}"><i class="icon-folder4"></i> Pago con Tarjeta</a>
                        </li>
                        @if (Auth::user()->isComplete())
                            <li>
                                <a href="{{ action('Users\PeriodosController@getIndex') }}"><i class="icon-download"></i> <span>Cerrar Periodos</span></a>
                            </li>
                            <li>
                                <a href="{{ action('Users\PeriodosMovimientosController@getBusqueda') }}"><i class="icon-bookmark"></i> <span>Reportes Contables</span></a>
                            </li>
                            <li>
                                <a href="{{ action('Users\PeriodosMovimientosPropuestasController@getIndex') }}"><i class="icon-book2"></i> <span>Declaraciones</span></a>
                            </li>
                        @endif
                    @endif
                    <li class="navigation-header"><span>Aplicación</span> <i class="icon-menu" title="aplicacion"></i></li>
                        @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                            @if (Auth::user()->isComplete())
                            <li>
                                <a href="{{ action('Users\AccountsController@getQuejasySugerencias') }}"><i class="icon-book2"></i> <span>Quejas y Sugerencias</span></a>
                            </li>
                            @endif
                        @endif
                    <li>
                    {!! HTML::link('#modal-terminos-condiciones', 'Ver Términos y Condiciones', [ 'class' => 'terminos-condiciones', 'data-toggle' => 'modal', 'data-target' => '#modal-terminos-condiciones' ]) !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
