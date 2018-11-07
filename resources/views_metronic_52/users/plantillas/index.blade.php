@section('title', 'Plantillas')

@section('content')
    @if (!Auth::user()->getPlantillaPDF())
        {!! HTML::link(action('Users\PlantillasController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Seleccionar Plantilla', [ 'class' => 'btn btn-default' ]) !!}
    @endif

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Plantilla</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Auth::user()->getPlantillaPDF())
                        <tr>
                            <td>{{ $Plantillas->getPlantillaPDF() }}</td>
                            <td>
                                {!! HTML::link(action('Users\PlantillasController@getEdit', [ 'id' => $Plantillas->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\PlantillasController@getDelete', [ 'id' => $Plantillas->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
