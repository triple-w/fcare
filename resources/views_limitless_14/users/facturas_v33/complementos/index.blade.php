
@section('title', 'Complementos')

@section('content')

    {!! HTML::link(action('Users\FacturasV33ComplementosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Complemento', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" data-order="[[ 3, &quot;desc&quot; ]]" datatable>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complementos as $complemento)
                        <tr>
                            <td>
                                {{ $complemento->getId() }}
                            </td>
                            <td>
                                Acciones
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
    {!! HTML::scriptLocal('webroot/js/limitless_14/facturas_index.js') !!}
@append
