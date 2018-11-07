
@section('title', 'Verificar CIEC')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable >
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>RFC</th>
                        <th>Ciec</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perfiles as $perfil)
                        <tr>
                            <td>{{ $perfil->getUser()->getEmail() }}</td>
                            <td>{{ $perfil->getRfc() }}</td>
                            <td>{{ $perfil->getCiec() }}</td>
                            <td>
                                {!! HTML::link(action('Users\AccountsController@getCiecVerificado', [ 'id' => $perfil->getId() ]), 'CIEC Verificado', ['class' => 'btn btn-success' ]) !!}
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
