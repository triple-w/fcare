@section('title', 'Contabilidad')

@section('content')

    @set('ultimaSubscripcion', \App\Models\UsersPagosContabilidadSubscripciones::getUltimaSubscripcion(Auth::user()))
    @if (empty($ultimaSubscripcion))
        <div class="alert alert-warning">
            No se ha encontrado ninguna suscripción activa.
        </div>
        @include('elements.form_pago', [ 'attrsForm' => [ 'id' => 'contabilidad-payment'], 'tipo' => 'CONTABILIDAD', 'estatus' => 'app' ])
    @else
        @set('pago', $ultimaSubscripcion->getPagoContabilidad())
        @set('now', \Carbon\Carbon::now())
        @set('fechaPago', $pago->getFechaPago())
        @set('diff', $now->diffInMonths($pago->getFechaPago()))
        @set('vencido', false)
        @if ($pago->getTipoPlan() === '1_MESES' && $diff >= 1)
            @set('vencido', true)
        @elseif ($pago->getTipoPlan() === '3_MESES' && $diff >= 3)
            @set('vencido', true)
        @elseif ($pago->getTipoPlan() === '6_MESES' && $diff >= 6)
            @set('vencido', true)
        @elseif ($pago->getTipoPlan() === '12_MESES' && $diff >= 12)
            @set('vencido', true)
        @endif
        @if ($vencido)
            @include('elements.form_pago', [ 'attrsForm' => [ 'id' => 'contabilidad-payment'], 'tipo' => 'CONTABILIDAD', 'estatus' => 'app' ])
        @else
            <div class="alert alert-info">
                Tienes vigente un plan.
            </div>
            <p>Tipo de plan: {{ $pago->getTipoPlan() }}</p>
            <p>Fecha de vencimiento: {{ $pago->getFechaTermino() }}
            </p>
            <?php
                $id = env('OPENPAY_ID');
                $sk = env('OPENPAY_SK');
                $env = env('APP_ENV');

                $openpay = Openpay::getInstance($id, $sk);
                if ($env === 'production') {
                    Openpay::setProductionMode(true);
                } else {
                    Openpay::setProductionMode(false);
                }

                $customerId = Auth::user()->getCustomerIdOpenPay();
                $customer = $openpay->customers->get($customerId);
                $subscripcion = $customer->subscriptions->get($ultimaSubscripcion->getIdSubscripcion());
            ?>
            <p>Tarjeta: {{ $subscripcion->card->serializableData['card_number'] }}</p>

            @set('planPendiente', \App\Models\UsersPagosContabilidad::getPlanPendiente(Auth::user()))
            @if (empty($planPendiente))
                <h3>Mi plan actual: {{ $ultimaSubscripcion->getPagoContabilidad()->getTipoPlan() }}</h3>
                <p>Deseas cambiar de plan?</p>
                {!! BootForm::open([ 'url' => action('Users\AccountsController@postCambiarPlan') ]) !!}
                    {!! BootForm::radios('tipoPlan', 'Tipo de Plan', \App\Models\UsersPagosContabilidad::getTiposPlanes() , null, null, [ 'class' => 'tipoPlan', 'required' => true ]) !!}
                    {!! BootForm::submit('Cambiar') !!}
                {!! BootForm::close() !!}
            @else
                <h3>Tienes un cambio de plan pendiente:</h3>
                <p>Plan Nuevo: {{ $planPendiente->getTipoPlanNuevo() }}</p>
            @endif

        @endif
    @endif

@endsection

@section('scripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/pago_contabilidad.js?v=1.7.0') !!}
@append
