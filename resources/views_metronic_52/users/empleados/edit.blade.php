@section('title', 'Agregar Cliente')

@section('content')
    
    {!! BootForm::open() !!}
        {!! BootForm::text('nombre', 'Nombre', $empleado->getNombre(), []) !!}
        {!! BootForm::text('rfc', 'RFC', $empleado->getRfc(), []) !!}
        {!! BootForm::text('curp', 'CURP', $empleado->getCurp(), []) !!}
        {!! BootForm::text('numSeguroSocial', 'Numero de Seguro Social', $empleado->getNumSeguroSocial(), []) !!}
        {!! BootForm::text('calle', 'Calle', $empleado->getCalle(), []) !!}
        {!! BootForm::text('localidad', 'Localidad', $empleado->getLocalidad(), []) !!}
        {!! BootForm::text('noExterior', 'No Exterior', $empleado->getNoExterior(), []) !!}
        {!! BootForm::text('noInterior', 'No Interior', $empleado->getNoInterior(), []) !!}
        {!! BootForm::text('referencia', 'Referencia', $empleado->getReferencia(), []) !!}
        {!! BootForm::text('colonia', 'Colonia', $empleado->getColonia(), []) !!}
        {!! BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), $empleado->getEstado(), []) !!}
        {!! BootForm::text('municipio', 'Municipio', $empleado->getMunicipio(), []) !!}
        {!! BootForm::text('pais', 'Pais', $empleado->getPais(), []) !!}
        {!! BootForm::text('codigoPostal', 'Codigo Postal', $empleado->getCodigoPostal(), []) !!}
        {!! BootForm::text('telefono', 'Telefono', $empleado->getTelefono(), []) !!}
        {!! BootForm::text('email', 'Email', $empleado->getEmail(), []) !!}
        {!! BootForm::text('registroPatronal', 'Registro Patronal', $empleado->getRegistroPatronal(), []) !!}
        {!! BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), $empleado->getTipoContrato(), []) !!}
        {!! BootForm::text('numeroEmpleado', 'Número de Empleado', $empleado->getNumeroEmpleado(), []) !!}
        {!! BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), $empleado->getRiesgoPuesto(), []) !!}
        {!! BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), $empleado->getTipoJornada(), []) !!}
        {!! BootForm::text('puesto', 'Puesto', $empleado->getPuesto(), []) !!}
        {!! BootForm::text('fechaInicioLaboral', 'Fecha de inicio de Labores', $empleado->getFechaInicioLaboral()->format('Y-m-d'), []) !!}
        {!! BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), $empleado->getTipoRegimen(), []) !!}
        {!! BootForm::text('salario', 'Salario', $empleado->getSalario(), []) !!}
        {!! BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), $empleado->getPeriodicidadPago(), []) !!}
        {!! BootForm::text('salarioDiarioIntegrado', 'Salaro diario Integrado', $empleado->getSalarioDiarioIntegrado(), []) !!}
        {!! BootForm::text('clabe', 'CLABE', $empleado->getClabe(), []) !!}
        {!! BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), $empleado->getBanco(), []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection