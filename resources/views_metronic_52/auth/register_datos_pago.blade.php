
@section('title', 'Registrarse')

@section('class_body', 'login-container')
@set('background', asset('webroot/img/accounting_background.jpg'))
@section('style_body', "background-image: url('{$background}'); background-position: center;")

@section('content')
    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">
                    <div class="well">
                        <ul id="stepy-004826721065003481-header" class="stepy-header">
                            <li id="stepy-004826721065003481-head-0" style="cursor: default;">
                                <div>1</div><span>Datos de usuario</span></li><li id="stepy-004826721065003481-head-0" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-1" style="cursor: default;">
                                <div>2</div><span>Datos de Perfil</span></li><li id="stepy-004826721065003481-head-1" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-2" style="stepy-active cursor: default;">
                                <div>3</div><span>Datos de Pago</span></li><li id="stepy-004826721065003481-head-2" style="cursor: default;">
                            </li>
                        </ul>
                    </div>
                    <br />
                    <br />
                    <br />

                    <div class="panel panel-body">
                        <div class="text-center">
                            <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                            <h5 class="content-group">Datos de Pago</h5>
                        </div>
                    @include('elements.form_pago', [ 'attrsForm' => [ 'id' => 'contabilidad-payment', 'url' => action('Users\AccountsController@postRegisterDatosPago') ], 'tipo' => 'CONTABILIDAD', 'user' => $user, 'estatus' => 'register' ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/pago_contabilidad.js?v=1.7.0') !!}
@append
