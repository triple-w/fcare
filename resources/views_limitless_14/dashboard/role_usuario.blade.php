
@section('title', 'Inicio')

@section('content')

    <div class="row">
        <div class="col-lg-4">
            <div class="panel bg-teal-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <span class="heading-text badge bg-teal-800"></span>
                    </div>

                    @set('cfdiEsteMes', \App\Models\Facturas::getGeneradosEsteMes())
                    @set('cfdiEsteMes', $cfdiEsteMes += \App\Models\Nominas::getGeneradosEsteMes())
                    <h3 class="no-margin">{{ $cfdiEsteMes }}</h3>
                    CFDI's Generados este mes
                    <div class="text-muted text-size-small"></div>
                </div>

                <div class="container-fluid">
                    <div id="members-online"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel bg-blue-400">
                <a href="{{ action('Users\FacturasV33Controller@getAdd') }}">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <span class="heading-text badge bg-blue-800"></span>
                        </div>

                        <h5 class="text-uppercase">Nueva Factura</h5>
                        <i class="counter-icon icmn-file-text3"></i>
                        <div class="text-muted text-size-small"></div>
                    </div>

                    <div class="container-fluid">
                        <div id="nueva-factura"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel bg-blue-400">
                <a href="{{ action('Users\NominasController@getAdd') }}">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <span class="heading-text badge bg-blue-800"></span>
                        </div>

                        <h5 class="text-uppercase">Nueva Nomina</h5>
                        <i class="counter-icon icmn-file-text3"></i>
                        <div class="text-muted text-size-small"></div>
                    </div>

                    <div class="container-fluid">
                        <div id="nueva-factura"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Pasos para uso de la apliación</div>
        <div class="panel-body">
            <p>Crear Cuenta: <i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i></p>
            <p>
                @if (Auth::user()->getCompletarPerfil())
                    Completar Perfil: <i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>
                @else
                    <a href="{{  action('Users\AccountsController@getPerfil') }}">Completar Perfil: <i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i></a>
                @endif
            </p>
            <p>
                @if (Auth::user()->getLlenarDatosPago())
                    LLenar datos de Pago: <i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>
                @else
                    <a href="{{ action('Pagos\ContabilidadController@getPago') }}">Llenar datos de pago: <i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i></a>
                @endif
            </p>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/dashboard.js?v=1.0.0') !!}
@append
