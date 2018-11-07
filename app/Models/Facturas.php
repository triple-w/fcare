<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\FacturasRepository")
* @ORM\Table(name="facturas", indexes={
*  @ORM\Index(name="IDX_TIPO", columns={"tipo_comprobante"}),
*  @ORM\Index(name="IDX_NOMBRE_COMPROBANTE", columns={"nombre_comprobante"})
* })
*/
class Facturas extends Info {

    const TIMBRADA = 'TIMBRADA';
    const CANCELADA = 'CANCELADA';
    const PENDIENTE = 'PENDIENTE';

    const FACTURA = 'Factura';
    const RECIBO_ARRENDAMIENTO = 'Recibo de Arrendamiento';
    const RECIBO_HONORARIOS = 'Recibo de Honorarios';
    const NOTA_CARGO = 'Nota de Cargo';
    const NOTA_CREDITO = 'Nota de Crédito';
    const CARTA_PORTE = 'Carta Porte';

    const VFACTURA = 'FACTURA';
    const VRECIBO_ARRENDAMIENTO = 'RECIBO_ARRENDAMIENTO';
    const VRECIBO_HONORARIOS = 'RECIBO_HONORARIOS';
    const VNOTA_CARGO = 'NOTA_CARGO';
    const VNOTA_CREDITO = 'NOTA_CREDITO';
    const VCARTA_PORTE = 'CARTA_PORTE';

    const INGRESO = 'INGRESO';
    const EGRESO = 'EGRESO';
    const TRASLADO = 'TRASLADO';

    public static function getNombresDocumentos() {
        return [
            self::VFACTURA => self::FACTURA,
            self::VRECIBO_ARRENDAMIENTO => self::RECIBO_ARRENDAMIENTO,
            self::VRECIBO_HONORARIOS => self::RECIBO_HONORARIOS,
            self::VNOTA_CARGO => self::NOTA_CARGO,
            self::VNOTA_CREDITO => self::NOTA_CREDITO,
            self::VCARTA_PORTE => self::CARTA_PORTE,
        ];
    }

    public static function getClavesImpuestos() {
        return [
            '' => 'Seleccione un impuesto',
            '001' => 'ISR',
            '002' => 'IVA',
            '003' => 'IEPS',
            '004' => 'Cedular',
        ];
    }

    public static function getNombreImpuestos($clave) {
        $impuestos = self::getClavesImpuestos();
        return isset($impuestos[$clave]) ? $impuestos[$clave] : $clave;
    }

    public static function getFormasPago() {
        return [
            '01' => 'Efectivo',
            '02' => 'Cheque nominativo',
            '03' => 'Transferencia electrónica de fondos',
            '04' => 'Tarjeta de crédito',
            '05' => 'Monedero electrónico',
            '06' => 'Dinero electrónico',
            '08' => 'Vales de despensa',
            '12' => 'Dación en pago',
            '13' => 'Pago por subrogación',
            '14' => 'Pago por consignación',
            '15' => 'Condonación',
            '17' => 'Compensación',
            '23' => 'Novación',
            '24' => 'Confusión',
            '25' => 'Remisión de deuda',
            '26' => 'Prescripción o caducidad',
            '27' => 'A satisfacción del acreedor',
            '28' => 'Tarjeta de débito',
            '29' => 'Tarjeta de servicios',
            '99' => 'Por definir',
        ];
    }

    public static function getMetodosPago() {
        return [
            'PUE' => 'Pago en una sola exhibición',
            'PIP'=> 'Pago inicial y parcialidades',
            'PPD'=> 'Pago en parcialidades o diferido',
        ];
    }

    public static function getUsosCFDI() {
        return [
            'G01' => 'Adquisición de mercancias',
            'G02' => 'Devoluciones, descuentos o bonificaciones',
            'G03' => 'Gastos en general',
            'I01' => 'Construcciones',
            'I02' => 'Mobilario y equipo de oficina por inversiones',
            'I03' => 'Equipo de transporte',
            'I04' => 'Equipo de computo y accesorios',
            'I05' => 'Dados, troqueles, moldes, matrices y herramental',
            'I06' => 'Comunicaciones telefónicas',
            'I07' => 'Comunicaciones satelitales',
            'I08' => 'Otra maquinaria y equipo',
            'D01' => 'Honorarios médicos, dentales y gastos hospitalarios.',
            'D02' => 'Gastos médicos por incapacidad o discapacidad',
            'D03' => 'Gastos funerales.',
            'D04' => 'Donativos.',
            'D05' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).',
            'D06' => 'Aportaciones voluntarias al SAR.',
            'D07' => 'Primas por seguros de gastos médicos.',
            'D08' => 'Gastos de transportación escolar obligatoria.',
            'D09' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.',
            'D10' => 'Pagos por servicios educativos (colegiaturas)',
            'P01' => 'Por definir',
        ];
    }

    public static function getTiposMonedas() {
        return [
            'AED' => 'Dirham de EAU',
            'AFN' => 'Afghani',
            'ALL' => 'Lek',
            'AMD' => 'Dram armenio',
            'ANG' => 'Florín antillano neerlandés',
            'AOA' => 'Kwanza',
            'ARS' => 'Peso Argentino',
            'AUD' => 'Dólar Australiano',
            'AWG' => 'Aruba Florin',
            'AZN' => 'Azerbaijanian Manat',
            'BAM' => 'Convertibles marca',
            'BBD' => 'Dólar de Barbados',
            'BDT' => 'Taka',
            'BGN' => 'Lev búlgaro',
            'BHD' => 'Dinar de Bahrein',
            'BIF' => 'Burundi Franc',
            'BMD' => 'Dólar de Bermudas',
            'BND' => 'Dólar de Brunei',
            'BOB' => 'Boliviano',
            'BOV' => 'Mvdol',
            'BRL' => 'Real brasileño',
            'BSD' => 'Dólar de las Bahamas',
            'BTN' => 'Ngultrum',
            'BWP' => 'Pula',
            'BYR' => 'Rublo bielorruso',
            'BZD' => 'Dólar de Belice',
            'CAD' => 'Dolar Canadiense',
            'CDF' => 'Franco congoleño',
            'CHE' => 'WIR Euro',
            'CHF' => 'Franco Suizo',
            'CHW' => 'Franc WIR',
            'CLF' => 'Unidad de Fomento',
            'CLP' => 'Peso chileno',
            'CNY' => 'Yuan Renminbi',
            'COP' => 'Peso Colombiano',
            'COU' => 'Unidad de Valor real',
            'CRC' => 'Colón costarricense',
            'CUC' => 'Peso Convertible',
            'CUP' => 'Peso Cubano',
            'CVE' => 'Cabo Verde Escudo',
            'CZK' => 'Corona checa',
            'DJF' => 'Franco de Djibouti',
            'DKK' => 'Corona danesa',
            'DOP' => 'Peso Dominicano',
            'DZD' => 'Dinar argelino',
            'EGP' => 'Libra egipcia',
            'ERN' => 'Nakfa',
            'ETB' => 'Birr etíope',
            'EUR' => 'Euro',
            'FJD' => 'Dólar de Fiji',
            'FKP' => 'Libra malvinense',
            'GBP' => 'Libra Esterlina',
            'GEL' => 'Lari',
            'GHS' => 'Cedi de Ghana',
            'GIP' => 'Libra de Gibraltar',
            'GMD' => 'Dalasi',
            'GNF' => 'Franco guineano',
            'GTQ' => 'Quetzal',
            'GYD' => 'Dólar guyanés',
            'HKD' => 'Dolar De Hong Kong',
            'HNL' => 'Lempira',
            'HRK' => 'Kuna',
            'HTG' => 'Gourde',
            'HUF' => 'Florín',
            'IDR' => 'Rupia',
            'ILS' => 'Nuevo Shekel Israelí',
            'INR' => 'Rupia india',
            'IQD' => 'Dinar iraquí',
            'IRR' => 'Rial iraní',
            'ISK' => 'Corona islandesa',
            'JMD' => 'Dólar Jamaiquino',
            'JOD' => 'Dinar jordano',
            'JPY' => 'Yen',
            'KES' => 'Chelín keniano',
            'KGS' => 'Som',
            'KHR' => 'Riel',
            'KMF' => 'Franco Comoro',
            'KPW' => 'Corea del Norte ganó',
            'KRW' => 'Won',
            'KWD' => 'Dinar kuwaití',
            'KYD' => 'Dólar de las Islas Caimán',
            'KZT' => 'Tenge',
            'LAK' => 'Kip',
            'LBP' => 'Libra libanesa',
            'LKR' => 'Rupia de Sri Lanka',
            'LRD' => 'Dólar liberiano',
            'LSL' => 'Loti',
            'LYD' => 'Dinar libio',
            'MAD' => 'Dirham marroquí',
            'MDL' => 'Leu moldavo',
            'MGA' => 'Ariary malgache',
            'MKD' => 'Denar',
            'MMK' => 'Kyat',
            'MNT' => 'Tugrik',
            'MOP' => 'Pataca',
            'MRO' => 'Ouguiya',
            'MUR' => 'Rupia de Mauricio',
            'MVR' => 'Rupia',
            'MWK' => 'Kwacha',
            'MXN' => 'Peso Mexicano',
            'MXV' => 'México Unidad de Inversión (UDI)',
            'MYR' => 'Ringgit malayo',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Dólar de Namibia',
            'NGN' => 'Naira',
            'NIO' => 'Córdoba Oro',
            'NOK' => 'Corona noruega',
            'NPR' => 'Rupia nepalí',
            'NZD' => 'Dólar de Nueva Zelanda',
            'OMR' => 'Rial omaní',
            'PAB' => 'Balboa',
            'PEN' => 'Nuevo Sol',
            'PGK' => 'Kina',
            'PHP' => 'Peso filipino',
            'PKR' => 'Rupia de Pakistán',
            'PLN' => 'Zloty',
            'PYG' => 'Guaraní',
            'QAR' => 'Qatar Rial',
            'RON' => 'Leu rumano',
            'RSD' => 'Dinar serbio',
            'RUB' => 'Rublo ruso',
            'RWF' => 'Franco ruandés',
            'SAR' => 'Riyal saudí',
            'SBD' => 'Dólar de las Islas Salomón',
            'SCR' => 'Rupia de Seychelles',
            'SDG' => 'Libra sudanesa',
            'SEK' => 'Corona sueca',
            'SGD' => 'Dolar De Singapur',
            'SHP' => 'Libra de Santa Helena',
            'SLL' => 'Leona',
            'SOS' => 'Chelín somalí',
            'SRD' => 'Dólar de Suriname',
            'SSP' => 'Libra sudanesa Sur',
            'STD' => 'Dobra',
            'SVC' => 'Colon El Salvador',
            'SYP' => 'Libra Siria',
            'SZL' => 'Lilangeni',
            'THB' => 'Baht',
            'TJS' => 'Somoni',
            'TMT' => 'Turkmenistán nuevo manat',
            'TND' => 'Dinar tunecino',
            'TOP' => 'Pa\'anga',
            'TRY' => 'Lira turca',
            'TTD' => 'Dólar de Trinidad y Tobago',
            'TWD' => 'Nuevo dólar de Taiwán',
            'TZS' => 'Shilling tanzano',
            'UAH' => 'Hryvnia',
            'UGX' => 'Shilling de Uganda',
            'USD' => 'Dolar americano',
            'USN' => 'Dólar estadounidense (día siguiente)',
            'UYI' => 'Peso Uruguay en Unidades Indexadas (URUIURUI)',
            'UYU' => 'Peso Uruguayo',
            'UZS' => 'Uzbekistán Sum',
            'VEF' => 'Bolívar',
            'VND' => 'Dong',
            'VUV' => 'Vatu',
            'WST' => 'Tala',
            'XAF' => 'Franco CFA BEAC',
            'XAG' => 'Plata',
            'XAU' => 'Oro',
            'XBA' => 'Unidad de Mercados de Bonos Unidad Europea Composite (EURCO)',
            'XBB' => 'Unidad Monetaria de Bonos de Mercados Unidad Europea (UEM-6)',
            'XBC' => 'Mercados de Bonos Unidad Europea unidad de cuenta a 9 (UCE-9)',
            'XBD' => 'Mercados de Bonos Unidad Europea unidad de cuenta a 17 (UCE-17)',
            'XCD' => 'Dólar del Caribe Oriental',
            'XDR' => 'DEG (Derechos Especiales de Giro)',
            'XOF' => 'Franco CFA BCEAO',
            'XPD' => 'Paladio',
            'XPF' => 'Franco CFP',
            'XPT' => 'Platino',
            'XSU' => 'Sucre',
            'XTS' => 'Códigos reservados específicamente para propósitos de prueba',
            'XUA' => 'Unidad ADB de Cuenta',
            'XXX' => 'Los códigos asignados para las transacciones en que intervenga ninguna moneda',
            'YER' => 'Rial yemení',
            'ZAR' => 'Rand',
            'ZMW' => 'Kwacha zambiano',
            'ZWL' => 'Zimbabwe Dólar',
        ];
    }


    private $rules = [
    ];

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="descuento",nullable=false)
    */
    private $descuento;

    /**
    * @ORM\Column(type="string",length=15,name="estatus",nullable=false)
    */
    private $estatus;

    /**
    * @ORM\Column(type="string",length=150,name="uuid",nullable=false)
    */
    private $uuid;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha",nullable=true)
    */
    private $fecha;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha_factura",nullable=true)
    */
    private $fechaFactura;

    /**
    * @ORM\Column(type="text",name="solicitud_timbre",nullable=false)
    */
    private $solicitudTimbre;

    /**
    * @ORM\Column(type="text",name="xml",nullable=false)
    */
    private $xml;

    /**
    * @ORM\Column(type="text",name="pdf",nullable=false)
    */
    private $pdf;

    /**
    * @ORM\Column(type="text",name="acuse",nullable=true)
    */
    private $acuse;

    /**
    * @ORM\Column(type="string",length=30,name="nombre_comprobante",nullable=false)
    */
    private $nombreComprobante;

    /**
    * @ORM\Column(type="string",length=30,name="tipo_comprobante",nullable=false)
    */
    private $tipoComprobante;

    /**
    * @ORM\Column(type="string",length=250,name="comentarios_pdf",nullable=true)
    */
    private $comentariosPDF;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="facturas")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="FacturasDetalles", mappedBy="factura", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $detalles;

    /**
    * @ORM\OneToMany(targetEntity="FacturasImpuestos", mappedBy="factura", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $impuestos;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->impuestos = new \Doctrine\Common\Collections\ArrayCollection();

        $this->user = $user;
        $this->fecha = \Carbon\Carbon::now();
    }

    public function getMontoTotal($xml = null) {
        if (empty($xml)) {
            $xml = new \DOMDocument();
            $xml->loadXml($this->getXml());
        }

        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        return empty($comprobante->getAttribute('total')) ? $comprobante->getAttribute('Total') : $comprobante->getAttribute('total');
    }

    public static function getTipoDocumento($nombreComprobante) {

        switch ($nombreComprobante) {
            case 'FACTURA':
                return self::INGRESO;
            break;
            case 'RECIBO_ARRENDAMIENTO':
                return self::INGRESO;
            break;
            case 'RECIBO_HONORARIOS':
                return self::INGRESO;
            break;
            case 'NOTA_CARGO':
                return self::INGRESO;
            break;
            case 'NOTA_CREDITO':
                return self::EGRESO;
            break;
            case 'CARTA_PORTE':
                return self::TRASLADO;
            break;
        }
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return UsersFacturas
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set fecha
     *
     * @param CarbonDateTime $fecha
     *
     * @return UsersFacturas
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return CarbonDateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersFacturas
     */
    public function setUser(\App\Models\Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Models\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add detalle
     *
     * @param \App\Models\FacturasDetalles $detalle
     *
     * @return UsersFacturas
     */
    public function addDetalle(\App\Models\FacturasDetalles $detalle)
    {
        $this->detalles[] = $detalle;

        return $this;
    }

    /**
     * Remove detalle
     *
     * @param \App\Models\FacturasDetalles $detalle
     */
    public function removeDetalle(\App\Models\FacturasDetalles $detalle)
    {
        $this->detalles->removeElement($detalle);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return UsersFacturas
     */
    public function setXml($xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     *
     * @return UsersFacturas
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set solicitudTimbre
     *
     * @param string $solicitudTimbre
     *
     * @return Facturas
     */
    public function setSolicitudTimbre($solicitudTimbre)
    {
        $this->solicitudTimbre = $solicitudTimbre;

        return $this;
    }

    /**
     * Get solicitudTimbre
     *
     * @return string
     */
    public function getSolicitudTimbre()
    {
        return $this->solicitudTimbre;
    }

    /**
     * Add impuesto
     *
     * @param \App\Models\FacturasImpuestos $impuesto
     *
     * @return Facturas
     */
    public function addImpuesto(\App\Models\FacturasImpuestos $impuesto)
    {
        $this->impuestos[] = $impuesto;

        return $this;
    }

    /**
     * Remove impuesto
     *
     * @param \App\Models\FacturasImpuestos $impuesto
     */
    public function removeImpuesto(\App\Models\FacturasImpuestos $impuesto)
    {
        $this->impuestos->removeElement($impuesto);
    }

    /**
     * Get impuestos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImpuestos()
    {
        return $this->impuestos;
    }

    /**
     * Set descuento
     *
     * @param string $descuento
     *
     * @return Facturas
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return string
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     *
     * @return Facturas
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set acuse
     *
     * @param string $acuse
     *
     * @return Facturas
     */
    public function setAcuse($acuse)
    {
        $this->acuse = $acuse;

        return $this;
    }

    /**
     * Get acuse
     *
     * @return string
     */
    public function getAcuse()
    {
        return $this->acuse;
    }

    /**
     * Set nombreComprobante
     *
     * @param string $nombreComprobante
     *
     * @return Facturas
     */
    public function setNombreComprobante($nombreComprobante)
    {
        $this->nombreComprobante = $nombreComprobante;
        $this->tipoComprobante = self::getTipoDocumento($nombreComprobante);

        return $this;
    }

    /**
     * Get nombreComprobante
     *
     * @return string
     */
    public function getNombreComprobante()
    {
        return $this->nombreComprobante;
    }

    /**
     * Set tipoComprobante
     *
     * @param string $tipoComprobante
     *
     * @return Facturas
     */
    public function setTipoComprobante($tipoComprobante)
    {
        $this->tipoComprobante = $tipoComprobante;

        return $this;
    }

    /**
     * Get tipoComprobante
     *
     * @return string
     */
    public function getTipoComprobante()
    {
        return $this->tipoComprobante;
    }

    /**
     * Set comentariosPDF
     *
     * @param string $comentariosPDF
     *
     * @return Facturas
     */
    public function setComentariosPDF($comentariosPDF)
    {
        $this->comentariosPDF = $comentariosPDF;

        return $this;
    }

    /**
     * Get comentariosPDF
     *
     * @return string
     */
    public function getComentariosPDF()
    {
        return $this->comentariosPDF;
    }

    /**
     * Set fechaFactura
     *
     * @param CarbonDate $fechaFactura
     *
     * @return Facturas
     */
    public function setFechaFactura($fechaFactura)
    {
        $this->fechaFactura = $fechaFactura;

        return $this;
    }

    /**
     * Get fechaFactura
     *
     * @return CarbonDate
     */
    public function getFechaFactura()
    {
        return $this->fechaFactura;
    }

}
