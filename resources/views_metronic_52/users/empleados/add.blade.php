@section('title', 'Agregar Cliente')

@section('content')

    {!! BootForm::open() !!}
        {!! BootForm::text('nombre', 'Nombre', null, []) !!}
        {!! BootForm::text('rfc', 'RFC', null, []) !!}
        {!! BootForm::text('curp', 'CURP', null, []) !!}
        {!! BootForm::text('numSeguroSocial', 'Numero de Seguro Social', null, []) !!}
        {!! BootForm::text('calle', 'Calle', null, []) !!}
        {!! BootForm::text('localidad', 'Localidad', null, []) !!}
        {!! BootForm::text('noExterior', 'No Exterior', null, []) !!}
        {!! BootForm::text('noInterior', 'No Interior', null, []) !!}
        {!! BootForm::text('referencia', 'Referencia', null, []) !!}
        {!! BootForm::text('colonia', 'Colonia', null, []) !!}
        {!! BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), null, []) !!}
        {!! BootForm::text('municipio', 'Municipio', null, []) !!}
        {!! BootForm::text('pais', 'Pais', null, []) !!}
        {!! BootForm::text('codigoPostal', 'Codigo Postal', null, []) !!}
        {!! BootForm::text('telefono', 'Telefono', null, []) !!}
        {!! BootForm::text('email', 'Email', null, []) !!}
        {!! BootForm::text('registroPatronal', 'Registro Patronal', null, []) !!}
        {!! BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), null, []) !!}
        {!! BootForm::text('numeroEmpleado', 'Número de Empleado', null, []) !!}
        {!! BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), null, []) !!}
        {!! BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), null, []) !!}
        {!! BootForm::text('puesto', 'Puesto', null, []) !!}
        {!! BootForm::text('fechaInicioLaboral', 'Fecha de inicio de Labores', null, []) !!}
        {!! BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), null, []) !!}
        {!! BootForm::text('salario', 'Salario', null, []) !!}
        {!! BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), null, []) !!}
        {!! BootForm::text('salarioDiarioIntegrado', 'Salaro diario Integrado', null, []) !!}
        {!! BootForm::text('clabe', 'CLABE', null, []) !!}
        {!! BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
