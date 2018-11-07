@section('title', 'Ver factura')

@section('content')

    <div class="margin-bottom-50">
        <div class="invoice-block">
            <div class="row">
            <div class="col-md-6">
                <h4>
                    {{-- Amazon Delivery --}}
                    <br />
                    <br />
                    @set('image', HTML::image('webroot/themes/themeforest-9110062/Templates/default/images/users/user-35.jpg', 'User', []))
                    @if (!empty(Auth::user()->getLogo()))
                        @set("logo", Auth::user()->getLogo()->getName())
                        @set('image', HTML::image("uploads/users_logos/thumbnails/{$logo}", 'User', []))
                    @endif
                    {!! $image !!}
                </h4>
                <address>
                    <br>
                      {{ $perfil->getNoExt() }} {{ $perfil->getCalle() }}<br>
                      {{ $perfil->getMunicipio() }}, {{ $perfil->getEstado() }} {{ $perfil->getCodigoPostal() }} <br>
                      <abbr title="Phone">TEL:</abbr> {{ $perfil->getTelefono() }}
                    <br />
                    <br />
                </address>
            </div>
            <div class="col-md-6 text-right">
                <h1>NOMINA</h1>
                    @set('document', new \DOMDocument($nomina->getSolicitudTimbre()))
                    <?php $document->loadXML($nomina->getSolicitudTimbre()) ?>
                    @set('comprobante', $document->getElementsByTagName('Comprobante')[0])
                    <h4>#{{ $comprobante->getAttribute('serie') }} - {{ $comprobante->getAttribute('folio') }}</h4>
                    {{-- <a href="#" class="btn btn-primary btn-sm invoice-print"><i class="icon-print-2"></i> Print</a> --}}
                <h4>{{ $document->getElementsByTagName('Receptor')[0]->getAttribute('rfc') }}</h4>
                <p><strong>FECHA : </strong> {{ $nomina->getFecha()->toFormattedDateString() }}</p>
                        <p><strong>ESTATUS : </strong>
                        @set('cssClass', 'success')
                        @if ($nomina->getEstatus() === \App\Models\Nominas::CANCELADA)
                            @set('cssClass', 'danger')
                        @endif
                        <span class="label label-{{ $cssClass }}">{{ $nomina->getEstatus() }}</span></p>
                <br />
                <br />
            </div>
        </div>
        <div class="table-responsive">
            <h3>Percepciones</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CLAVE</th>
                        <th>CODIGO</th>
                        <th>CONCEPTO</th>
                        <th>IMPORTE GRAVADO</th>
                        <th>IMPORTE EXENTO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nomina->getPercepciones() as $percepcion)
                        <tr>
                            <td>{{ $percepcion->getClave() }}</td>
                            <td>{{ $percepcion->getCodigo() }}</td>
                            <td>{{ $percepcion->getConcepto() }}</td>
                            <td>{{ $percepcion->getImporteGravado() }}</td>
                            <td>{{ $percepcion->getImporteExcento() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <h3>Deducciones</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CLAVE</th>
                        <th>CODIGO</th>
                        <th>CONCEPTO</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nomina->getDeducciones() as $deduccion)
                        <tr>
                            <td>{{ $deduccion->getClave() }}</td>
                            <td>{{ $deduccion->getCodigo() }}</td>
                            <td>{{ $deduccion->getConcepto() }}</td>
                            <td>{{ $deduccion->getImporte() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <h3>Otros Pagos</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CLAVE</th>
                        <th>CODIGO</th>
                        <th>CONCEPTO</th>
                        <th>IMPORTE</th>
                        <th>SUBSIDIO</th>
                        <th>SALDO FAVOR</th>
                        <th>AÑO</th>
                        <th>REMANENTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nomina->getOtrosPagos() as $otroPago)
                        <tr>
                            <td>{{ $otroPago->getClave() }}</td>
                            <td>{{ $otroPago->getCodigo() }}</td>
                            <td>{{ $otroPago->getConcepto() }}</td>
                            <td>{{ $otroPago->getImporte() }}</td>
                            <td>{{ $otroPago->getSubsidioCausado() }}</td>
                            <td>{{ $otroPago->getSaldoFavor() }}</td>
                            <td>{{ $otroPago->getAnio() }}</td>
                            <td>{{ $otroPago->getRemanente() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! HTML::link(URL::previous(), '<i class="icmn-undo" aria-hidden="true"></i> Regresar', [ 'class' => 'btn btn-info', 'style' => 'float:right' ]) !!}
    </div>

    

@endsection