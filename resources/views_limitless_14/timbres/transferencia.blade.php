
@section('title', 'Transferir Timbres')

@section('content')

    {!! BootForm::open(); !!}
    	@set('usuarios', [])
    	@foreach (\App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' ]) as $usuario)
    		@set("usuarios[$usuario->getId()]", $usuario->getUsername())
    	@endforeach
    	{!! BootForm::select('userTransferencia', 'Usuario', $usuarios, [], []) !!}
        {!! BootForm::text('numeroTimbres', 'Numero de timbres', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection