<?php $__env->startSection('title', 'Agregar Cliente'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('nombre', 'Nombre', null, []); ?>

        <?php echo BootForm::text('rfc', 'RFC', null, []); ?>

        <?php echo BootForm::text('curp', 'CURP', null, []); ?>

        <?php echo BootForm::text('numSeguroSocial', 'Numero de Seguro Social', null, []); ?>

        <?php echo BootForm::text('calle', 'Calle', null, []); ?>

        <?php echo BootForm::text('localidad', 'Localidad', null, []); ?>

        <?php echo BootForm::text('noExterior', 'No Exterior', null, []); ?>

        <?php echo BootForm::text('noInterior', 'No Interior', null, []); ?>

        <?php echo BootForm::text('referencia', 'Referencia', null, []); ?>

        <?php echo BootForm::text('colonia', 'Colonia', null, []); ?>

        <?php echo BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), null, []); ?>

        <?php echo BootForm::text('municipio', 'Municipio', null, []); ?>

        <?php echo BootForm::text('pais', 'Pais', null, []); ?>

        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', null, []); ?>

        <?php echo BootForm::text('telefono', 'Telefono', null, []); ?>

        <?php echo BootForm::text('email', 'Email', null, []); ?>

        <?php echo BootForm::text('registroPatronal', 'Registro Patronal', null, []); ?>

        <?php echo BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), null, []); ?>

        <?php echo BootForm::text('numeroEmpleado', 'Número de Empleado', null, []); ?>

        <?php echo BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), null, []); ?>

        <?php echo BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), null, []); ?>

        <?php echo BootForm::text('puesto', 'Puesto', null, []); ?>

        <?php echo BootForm::text('fechaInicioLaboral', 'Fecha de inicio de Labores', null, []); ?>

        <?php echo BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), null, []); ?>

        <?php echo BootForm::text('salario', 'Salario', null, []); ?>

        <?php echo BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), null, []); ?>

        <?php echo BootForm::text('salarioDiarioIntegrado', 'Salaro diario Integrado', null, []); ?>

        <?php echo BootForm::text('clabe', 'CLABE', null, []); ?>

        <?php echo BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), null, []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>
