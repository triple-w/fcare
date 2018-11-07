
@section('title', 'Periodos')

@section('content')

    @if (empty(Auth::user()->getPerfil()->getCiec()))
        {!! Alert::danger('No existe un ciec configurado, porfavor ingresalo para poder continuar') !!}
    @else
        {!! Alert::info('Si deseas cambiar tu CIEC solo ingresalo nuevamente') !!}
    @endif
    {!! BootForm::open([ 'url' => action('Users\PeriodosController@postChangeCiec'), 'method' => 'POST' ]) !!}
        {!! BootForm::password('ciec', 'CIEC', []) !!}
        {!! BootForm::submit('Aceptar') !!}
    {!! BootForm::close() !!}

    {!! HTML::link(action('Users\PeriodosController@getTerminar'), '<i class="icon-plus2" aria-hidden="true"></i> Terminar Periodo', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Emitidos</th>
                        <th>Recibidos</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->getMes() }} - {{ $periodo->getAnio() }}</td>
                            <td>{{ count(\App\Models\UsersPeriodosDocumentos::getEmitidos($periodo)) }}</td>
                            <td>{{ count(\App\Models\UsersPeriodosDocumentos::getRecibidos($periodo)) }}</td>
                            <td>{{ $periodo->getEstatus() }}</td>
                            <td>
                                {!! HTML::link(action('Users\PeriodosController@getEdit', [ 'id' => $periodo->getid() ]), '<i class="icon-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
