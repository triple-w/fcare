@section('title', 'Agregar Plantilla')

@section('content')
	{!! BootForm::open() !!}
	<div class="row">
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="1">
			<img src="{{asset('webroot/img/plantillas/p1.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="2">
			<img src="{{asset('webroot/img/plantillas/p2.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="3">
			<img src="{{asset('webroot/img/plantillas/p3.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="4">
			<img src="{{asset('webroot/img/plantillas/p4.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="5">
			<img src="{{asset('webroot/img/plantillas/p5.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="6">
			<img src="{{asset('webroot/img/plantillas/p6.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="7">
			<img src="{{asset('webroot/img/plantillas/p7.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="8">
			<img src="{{asset('webroot/img/plantillas/p8.png')}}" width="80%">
		</div>
		<div class="col-md-4">
			<input type="radio" name="plantilla" value="9">
			<img src="{{asset('webroot/img/plantillas/p9.png')}}" width="80%">
		</div>
	</div>
	{!! BootForm::submit('Aceptar'); !!}

	{!! BootForm::close(); !!}
@endsection