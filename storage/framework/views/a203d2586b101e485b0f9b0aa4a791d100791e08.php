<?php $__env->startSection('title', 'Agregar Cliente'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('nombre', 'Nombre', $empleado->getNombre(), []); ?>

        <?php echo BootForm::text('rfc', 'RFC', $empleado->getRfc(), []); ?>

        <?php echo BootForm::text('curp', 'CURP', $empleado->getCurp(), []); ?>

        <?php echo BootForm::text('numSeguroSocial', 'Numero de Seguro Social', $empleado->getNumSeguroSocial(), []); ?>

        <?php echo BootForm::text('calle', 'Calle', $empleado->getCalle(), []); ?>

        <?php echo BootForm::text('localidad', 'Localidad', $empleado->getLocalidad(), []); ?>

        <?php echo BootForm::text('noExterior', 'No Exterior', $empleado->getNoExterior(), []); ?>

        <?php echo BootForm::text('noInterior', 'No Interior', $empleado->getNoInterior(), []); ?>

        <?php echo BootForm::text('referencia', 'Referencia', $empleado->getReferencia(), []); ?>

        <?php echo BootForm::text('colonia', 'Colonia', $empleado->getColonia(), []); ?>

        <?php echo BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), $empleado->getEstado(), []); ?>

        <?php echo BootForm::text('municipio', 'Municipio', $empleado->getMunicipio(), []); ?>

        <?php echo BootForm::text('pais', 'Pais', $empleado->getPais(), []); ?>

        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', $empleado->getCodigoPostal(), []); ?>

        <?php echo BootForm::text('telefono', 'Telefono', $empleado->getTelefono(), []); ?>

        <?php echo BootForm::text('email', 'Email', $empleado->getEmail(), []); ?>

        <?php echo BootForm::text('registroPatronal', 'Registro Patronal', $empleado->getRegistroPatronal(), []); ?>

        <?php echo BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), $empleado->getTipoContrato(), []); ?>

        <?php echo BootForm::text('numeroEmpleado', 'Número de Empleado', $empleado->getNumeroEmpleado(), []); ?>

        <?php echo BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), $empleado->getRiesgoPuesto(), []); ?>

        <?php echo BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), $empleado->getTipoJornada(), []); ?>

        <?php echo BootForm::text('puesto', 'Puesto', $empleado->getPuesto(), []); ?>

        <?php echo BootForm::text('fechaInicioLaboral', 'Fecha de inicio de Labores', $empleado->getFechaInicioLaboral()->format('Y-m-d'), []); ?>

        <?php echo BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), $empleado->getTipoRegimen(), []); ?>

        <?php echo BootForm::text('salario', 'Salario', $empleado->getSalario(), []); ?>

        <?php echo BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), $empleado->getPeriodicidadPago(), []); ?>

        <?php echo BootForm::text('salarioDiarioIntegrado', 'Salaro diario Integrado', $empleado->getSalarioDiarioIntegrado(), []); ?>

        <?php echo BootForm::text('clabe', 'CLABE', $empleado->getClabe(), []); ?>

        <?php echo BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), $empleado->getBanco(), []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>