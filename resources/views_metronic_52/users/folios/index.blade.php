
@section('title', 'Folios')

@section('content')

    @if (!empty(\App\Models\Folios::getDiffFolios(Auth::user(), \App\Models\Folios::getTiposFolio())))
        {!! HTML::link(action('Users\FoliosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Folio', [ 'class' => 'btn btn-default' ]) !!}
    @endif

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($folios as $folio)
                        <tr>
                            <td>{{ $folio->getTipo() }}</td>
                            <td>{{ $folio->getSerie() }}</td>
                            <td>{{ $folio->getFolio() }}</td>
                            <td>
                                {!! HTML::link(action('Users\FoliosController@getEdit', [ 'id' => $folio->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\FoliosController@getDelete', [ 'id' => $folio->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/generals.js') !!}
@append
