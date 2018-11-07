
@section('title', 'Facturas pendientes por generar')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Plan</th>
                        <th>Estatus</th>
                        <th>Monto</th>
                        <th>Datos usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facturasContabilidad as $contabilidad)
                        <tr>
                            <td>CONTABILIDAD</td>
                            <td>{{ $contabilidad->getUser()->getUsername() }}</td>
                            <td>{{ $contabilidad->getTipoPlan() }}</td>
                            <td>{{ $contabilidad->getStatusFactura() }}</td>
                            <td>{{ $contabilidad->getPrecio() }}</td>
                            <td>
                                <ul>
                                    <li>Regimen: {{ $contabilidad->getUser()->getPerfil()->getNombreRegimen() }}</li>
                                    <li>RFC: {{ $contabilidad->getUser()->getPerfil()->getRfc() }}</li>
                                    <li>Razon Social: {{ $contabilidad->getUser()->getPerfil()->getRazonSocial() }}</li>
                                    <li>Calle: {{ $contabilidad->getUser()->getPerfil()->getCalle() }}</li>
                                    <li>Número Exterior: {{ $contabilidad->getUser()->getPerfil()->getNoExt() }}</li>
                                    <li>Número Interior: {{ $contabilidad->getUser()->getPerfil()->getNoInt() }}</li>
                                    <li>Colonia: {{ $contabilidad->getUser()->getPerfil()->getColonia() }}</li>
                                    <li>Municipio: {{ $contabilidad->getUser()->getPerfil()->getMunicipio() }}</li>
                                    <li>Localidad: {{ $contabilidad->getUser()->getPerfil()->getLocalidad() }}</li>
                                    <li>Estado: {{ $contabilidad->getUser()->getPerfil()->getEstado() }}</li>
                                    <li>Codigo Postal: {{ $contabilidad->getUser()->getPerfil()->getCodigoPostal() }}</li>
                                    <li>Pais: {{ $contabilidad->getUser()->getPerfil()->getPais() }}</li>
                                    <li>Telefono: {{ $contabilidad->getUser()->getPerfil()->getTelefono() }}</li>
                                </ul>
                            </td>
                            <td>
                                {!! HTML::link(action('Users\ReportesAdminController@getFacturaEnviadaContabilidad', [ 'id' => $contabilidad->getId() ]), 'Enviar', ['class' => 'btn btn-info' ]) !!}
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($facturasTimbres as $timbre)
                        <tr>
                            <td>TIMBRES</td>
                            <td>{{ $timbre->getUser()->getUsername() }}</td>
                            <td>NA</td>
                            <td>{{ $timbre->getStatusFactura() }}</td>
                            <td>{{ $timbre->getMonto() }}</td>
                            <td>
                                <ul>
                                    <li>Regimen: {{ $timbre->getUser()->getPerfil()->getNombreRegimen() }}</li>
                                    <li>RFC: {{ $timbre->getUser()->getPerfil()->getRfc() }}</li>
                                    <li>Razon Social: {{ $timbre->getUser()->getPerfil()->getRazonSocial() }}</li>
                                    <li>Calle: {{ $timbre->getUser()->getPerfil()->getCalle() }}</li>
                                    <li>Número Exterior: {{ $timbre->getUser()->getPerfil()->getNoExt() }}</li>
                                    <li>Número Interior: {{ $timbre->getUser()->getPerfil()->getNoInt() }}</li>
                                    <li>Colonia: {{ $timbre->getUser()->getPerfil()->getColonia() }}</li>
                                    <li>Municipio: {{ $timbre->getUser()->getPerfil()->getMunicipio() }}</li>
                                    <li>Localidad: {{ $timbre->getUser()->getPerfil()->getLocalidad() }}</li>
                                    <li>Estado: {{ $timbre->getUser()->getPerfil()->getEstado() }}</li>
                                    <li>Codigo Postal: {{ $timbre->getUser()->getPerfil()->getCodigoPostal() }}</li>
                                    <li>Pais: {{ $timbre->getUser()->getPerfil()->getPais() }}</li>
                                    <li>Telefono: {{ $timbre->getUser()->getPerfil()->getTelefono() }}</li>
                                </ul>
                            </td>
                            <td>
                                {!! HTML::link(action('Users\ReportesAdminController@getFacturaEnviadaTimbres', [ 'id' => $timbre->getId() ]), 'Enviar', ['class' => 'btn btn-info' ]) !!}
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
