@section('title', 'Clientes')

@section('content')
	
	@if (Auth::user()->getCorreo_per())
  
    @else
    	{!! HTML::link(action('Users\EmailPController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Email', [ 'class' => 'btn btn-default' ]) !!}
    @endif

    <br />
    <br />

    <div class="margin-bottom-50">
        <table class="table table-hover nowrap" id="example1" width="100%" datatable>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Emails as $emails)
                    <tr>
                        <td>{{ $emails->getNombre() }}</td>
                        <td>{{ $emails->getEmail() }}</td>
                        <td>
                            {!! HTML::link(action('Users\EmailPController@getEdit', [ 'id' => $emails->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                            {!! HTML::link(action('Users\EmailPController@getDelete', [ 'id' => $emails->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection