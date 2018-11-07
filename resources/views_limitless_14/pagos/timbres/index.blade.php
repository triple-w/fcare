@section('title', 'Timbres')

@section('content')

    @include('elements.form_pago', [ 'attrsForm' => [ 'id' => 'timbres-payment'], 'tipo' => 'TIMBRES' ])

@endsection

@section('scripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/pago_timbres.js?v=1.4.0') !!}
@append
