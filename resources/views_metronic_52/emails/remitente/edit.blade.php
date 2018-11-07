@section('title','Email Personalizado')
	
@section('content')

	{!! BootForm::open() !!}
		{!! BootForm::text('email', 'Email', null, []) !!}
		{!! BootForm::text('nombre', 'Nombre', null, []) !!}
		{!! BootForm::submit('Aceptar'); !!}
	{!! BootForm::close(); !!}
	
@endsection