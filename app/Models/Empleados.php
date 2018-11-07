<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="empleados")
*/
class Empleados extends DoctrineEntity {

    public static function getTipoContratos() {
        return [
            '01' => 'Contrato de trabajo por tiempo indeterminado',
            '02' => 'Contrato de trabajo para obra determinada',
            '03' => 'Contrato de trabajo por tiempo determinado',
            '04' => 'Contrato de trabajo por temporada',
            '05' => 'Contrato de trabajo sujeto a prueba',
            '06' => 'Contrato de trabajo con capacitación inicial',
            '07' => 'Modalidad de contratación por pago de hora laborada',
            '08' => 'Modalidad de trabajo por comisión laboral',
            '09' => 'Modalidades de contratación donde no existe relación de trabajo',
            '10' => 'Jubilación, pensión, retiro.',
            '99' => 'Otro contrato',
        ];
    }

    public static function getRiesgoPuestos() {
        return [
            '1' => 'Clase I',
            '2' => 'Clase II',
            '3' => 'Clase III',
            '4' => 'Clase IV',
            '5' => 'Clase V',
        ];
    }

    public static function getTipoJornadas() {
        return [
            '01' => 'Diurna',
            '02' => 'Nocturna',
            '03' => 'Mixta',
            '04' => 'Por hora',
            '05' => 'Reducida',
            '06' => 'Continuada',
            '07' => 'Partida',
            '08' => 'Por turnos',
            '99' => 'Otra Jornada',
        ];
    }

    public static function getTipoRegimenes() {
        return [
            '02' => 'Sueldos',
            '03' => 'Jubilados',
            '04' => 'Pensionados',
            '05' => 'Asimilados Miembros Sociedades Cooperativas Produccion',
            '06' => 'Asimilados Integrantes Sociedades Asociaciones Civiles',
            '07' => 'Asimilados Miembros consejos',
            '08' => 'Asimilados comisionistas',
            '09' => 'Asimilados Honorarios',
            '10' => 'Asimilados acciones',
            '11' => 'Asimilados otros',
            '99' => 'Otro Regimen',
        ];
    }

    public static function getPeriodicidadPagos() {
        return [
            '01' => 'Diario',
            '02' => 'Semanal',
            '03' => 'Catorcenal',
            '04' => 'Quincenal',
            '05' => 'Mensual',
            '06' => 'Bimestral',
            '07' => 'Unidad obra',
            '08' => 'Comisión',
            '09' => 'Precio alzado',
            '99' => 'Otra Periodicidad',
        ];
    }

    public static function getEntidadFederativa() {
        return [
            'AGU' => 'Aguascalientes',
            'BCN' => 'Baja California',
            'BCS' => 'Baja California Sur',
            'CAM' => 'Campeche',
            'CHP' => 'Chiapas',
            'CHH' => 'Chihuahua',
            'COA' => 'Coahuila',
            'COL' => 'Colima',
            'DIF' => 'Ciudad de México',
            'DUR' => 'Durango',
            'GUA' => 'Guanajuato',
            'GRO' => 'Guerrero',
            'HID' => 'Hidalgo',
            'JAL' => 'Jalisco',
            'MEX' => 'Estado de México',
            'MIC' => 'Michoacán',
            'MOR' => 'Morelos',
            'NAY' => 'Nayarit',
            'NLE' => 'Nuevo León',
            'OAX' => 'Oaxaca',
            'PUE' => 'Puebla',
            'QUE' => 'Querétaro',
            'ROO' => 'Quintana Roo',
            'SLP' => 'San Luis Potosí',
            'SIN' => 'Sinaloa',
            'SON' => 'Sonora',
            'TAB' => 'Tabasco',
            'TAM' => 'Tamaulipas',
            'TLA' => 'Tlaxcala',
            'VER' => 'Veracruz',
            'YUC' => 'Yucatán',
            'ZAC' => 'Zacatecas',
        ];
    }

    public static function getBancos() {
        return [
            '002' => 'BANAMEX',
            '006' => 'BANCOMEXT',
            '009' => 'BANOBRAS',
            '012' => 'BBVA BANCOMER',
            '014' => 'SANTANDER',
            '019' => 'BANJERCITO',
            '021' => 'HSBC',
            '030' => 'BAJIO',
            '032' => 'IXE',
            '036' => 'INBURSA',
            '037' => 'INTERACCIONES',
            '042' => 'MIFEL',
            '044' => 'SCOTIABANK',
            '058' => 'BANREGIO',
            '059' => 'INVEX',
            '060' => 'BANSI',
            '062' => 'AFIRME',
            '072' => 'BANORTE',
            '102' => 'THE ROYAL BANK',
            '103' => 'AMERICAN EXPRESS',
            '106' => 'BAMSA',
            '108' => 'TOKYO',
            '110' => 'JP MORGAN',
            '112' => 'BMONEX',
            '113' => 'VE POR MAS',
            '116' => 'ING',
            '124' => 'DEUTSCHE',
            '126' => 'CREDIT SUISSE',
            '127' => 'AZTECA',
            '128' => 'AUTOFIN',
            '129' => 'BARCLAYS',
            '130' => 'COMPARTAMOS',
            '131' => 'BANCO FAMSA',
            '132' => 'BMULTIVA',
            '133' => 'ACTINVER',
            '134' => 'WAL-MART',
            '135' => 'NAFIN',
            '136' => 'INTERBANCO',
            '137' => 'BANCOPPEL',
            '138' => 'ABC CAPITAL',
            '139' => 'UBS BANK',
            '140' => 'CONSUBANCO',
            '141' => 'VOLKSWAGEN',
            '143' => 'CIBANCO',
            '145' => 'BBASE',
            '166' => 'BANSEFI',
            '168' => 'HIPOTECARIA FEDERAL',
            '600' => 'MONEXCB',
            '601' => 'GBM',
            '602' => 'MASARI',
            '605' => 'VALUE',
            '606' => 'ESTRUCTURADORES',
            '607' => 'TIBER',
            '608' => 'VECTOR',
            '610' => 'B&B',
            '614' => 'ACCIVAL',
            '615' => 'MERRILL LYNCH',
            '616' => 'FINAMEX',
            '617' => 'VALMEX',
            '618' => 'UNICA',
            '619' => 'MAPFRE',
            '620' => 'PROFUTURO',
            '621' => 'CB ACTINVER',
            '622' => 'OACTIN',
            '623' => 'SKANDIA',
            '626' => 'CBDEUTSCHE',
            '627' => 'ZURICH',
            '628' => 'ZURICHVI',
            '629' => 'SU CASITA',
            '630' => 'CB INTERCAM',
            '631' => 'CI BOLSA',
            '632' => 'BULLTICK CB',
            '633' => 'STERLING',
            '634' => 'FINCOMUN',
            '636' => 'HDI SEGUROS',
            '637' => 'ORDER',
            '638' => 'AKALA',
            '640' => 'CB JPMORGAN',
            '642' => 'REFORMA',
            '646' => 'STP',
            '647' => 'TELECOMM',
            '648' => 'EVERCORE',
            '649' => 'SKANDIA',
            '651' => 'SEGMTY',
            '652' => 'ASEA',
            '653' => 'KUSPIT',
            '655' => 'SOFIEXPRESS',
            '656' => 'UNAGRA',
            '659' => 'OPCIONES EMPRESARIALES DEL NOROESTE',
            '901' => 'CLS',
            '902' => 'INDEVAL',
            '670' => 'LIBERTAD',
        ];
    }

    private $rules = [
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=90,name="nombre",nullable=false)
    */
    private $nombre;

    /**
    * @ORM\Column(type="string",length=50,name="rfc",nullable=false)
    */
    private $rfc;

    /**
    * @ORM\Column(type="string",length=50,name="curp",nullable=false)
    */
    private $curp;

    /**
    * @ORM\Column(type="string",length=50,name="num_seguro_social",nullable=false)
    */
    private $numSeguroSocial;

    /**
    * @ORM\Column(type="string",length=90,name="calle",nullable=false)
    */
    private $calle;

    /**
    * @ORM\Column(type="string",length=90,name="localidad",nullable=false)
    */
    private $localidad;

    /**
    * @ORM\Column(type="string",length=10,name="no_exterior",nullable=false)
    */
    private $noExterior;

    /**
    * @ORM\Column(type="string",length=10,name="no_interior",nullable=false)
    */
    private $noInterior;

    /**
    * @ORM\Column(type="string",length=90,name="referencia",nullable=false)
    */
    private $referencia;

    /**
    * @ORM\Column(type="string",length=50,name="colonia",nullable=false)
    */
    private $colonia;

    /**
    * @ORM\Column(type="string",length=50,name="estado",nullable=false)
    */
    private $estado;

    /**
    * @ORM\Column(type="string",length=50,name="municipio",nullable=false)
    */
    private $municipio;

    /**
    * @ORM\Column(type="string",length=50,name="pais",nullable=false)
    */
    private $pais;

    /**
    * @ORM\Column(type="string",length=30,name="codigo_postal",nullable=false)
    */
    private $codigoPostal;

    /**
    * @ORM\Column(type="string",length=30,name="telefono",nullable=true)
    */
    private $telefono;

    /**
    * @ORM\Column(type="string",length=30,name="email",nullable=true)
    */
    private $email;

    /**
    * @ORM\Column(type="string",length=90,name="registro_patronal",nullable=false)
    */
    private $registroPatronal;

    /**
    * @ORM\Column(type="string",length=90,name="tipo_contrato",nullable=false)
    */
    private $tipoContrato;

    /**
    * @ORM\Column(type="string",length=50,name="numero_empleado",nullable=false)
    */
    private $numeroEmpleado;

    /**
    * @ORM\Column(type="string",length=30,name="riesgo_puesto",nullable=false)
    */
    private $riesgoPuesto;

    /**
    * @ORM\Column(type="string",length=30,name="tipo_jornada",nullable=false)
    */
    private $tipoJornada;

    /**
    * @ORM\Column(type="string",length=50,name="puesto",nullable=false)
    */
    private $puesto;

    /**
    * @ORM\Column(type="CarbonDate",name="fecha_inicio_laboral",nullable=true)
    */
    private $fechaInicioLaboral;

    /**
    * @ORM\Column(type="string",length=90,name="tipo_regimen",nullable=false)
    */
    private $tipoRegimen;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="salario",nullable=false)
    */
    private $salario;

    /**
    * @ORM\Column(type="string",length=30,name="periodicidad_pago",nullable=false)
    */
    private $periodicidadPago;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="salario_diario_integrado",nullable=false)
    */
    private $salarioDiarioIntegrado;

    /**
    * @ORM\Column(type="string",length=90,name="clabe",nullable=false)
    */
    private $clabe;

    /**
    * @ORM\Column(type="string",length=50,name="banco",nullable=false)
    */
    private $banco;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="empleados")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empleados
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Empleados
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set curp
     *
     * @param string $curp
     *
     * @return Empleados
     */
    public function setCurp($curp)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get curp
     *
     * @return string
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set numSeguroSocial
     *
     * @param string $numSeguroSocial
     *
     * @return Empleados
     */
    public function setNumSeguroSocial($numSeguroSocial)
    {
        $this->numSeguroSocial = $numSeguroSocial;

        return $this;
    }

    /**
     * Get numSeguroSocial
     *
     * @return string
     */
    public function getNumSeguroSocial()
    {
        return $this->numSeguroSocial;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Empleados
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Empleados
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set noExterior
     *
     * @param string $noExterior
     *
     * @return Empleados
     */
    public function setNoExterior($noExterior)
    {
        $this->noExterior = $noExterior;

        return $this;
    }

    /**
     * Get noExterior
     *
     * @return string
     */
    public function getNoExterior()
    {
        return $this->noExterior;
    }

    /**
     * Set noInterior
     *
     * @param string $noInterior
     *
     * @return Empleados
     */
    public function setNoInterior($noInterior)
    {
        $this->noInterior = $noInterior;

        return $this;
    }

    /**
     * Get noInterior
     *
     * @return string
     */
    public function getNoInterior()
    {
        return $this->noInterior;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return Empleados
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     *
     * @return Empleados
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Empleados
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Empleados
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Empleados
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Empleados
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Empleados
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Empleados
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set registroPatronal
     *
     * @param string $registroPatronal
     *
     * @return Empleados
     */
    public function setRegistroPatronal($registroPatronal)
    {
        $this->registroPatronal = $registroPatronal;

        return $this;
    }

    /**
     * Get registroPatronal
     *
     * @return string
     */
    public function getRegistroPatronal()
    {
        return $this->registroPatronal;
    }

    /**
     * Set tipoContrato
     *
     * @param string $tipoContrato
     *
     * @return Empleados
     */
    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return string
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    /**
     * Set numeroEmpleado
     *
     * @param string $numeroEmpleado
     *
     * @return Empleados
     */
    public function setNumeroEmpleado($numeroEmpleado)
    {
        $this->numeroEmpleado = $numeroEmpleado;

        return $this;
    }

    /**
     * Get numeroEmpleado
     *
     * @return string
     */
    public function getNumeroEmpleado()
    {
        return $this->numeroEmpleado;
    }

    /**
     * Set riesgoPuesto
     *
     * @param string $riesgoPuesto
     *
     * @return Empleados
     */
    public function setRiesgoPuesto($riesgoPuesto)
    {
        $this->riesgoPuesto = $riesgoPuesto;

        return $this;
    }

    /**
     * Get riesgoPuesto
     *
     * @return string
     */
    public function getRiesgoPuesto()
    {
        return $this->riesgoPuesto;
    }

    /**
     * Set tipoJornada
     *
     * @param string $tipoJornada
     *
     * @return Empleados
     */
    public function setTipoJornada($tipoJornada)
    {
        $this->tipoJornada = $tipoJornada;

        return $this;
    }

    /**
     * Get tipoJornada
     *
     * @return string
     */
    public function getTipoJornada()
    {
        return $this->tipoJornada;
    }

    /**
     * Set puesto
     *
     * @param string $puesto
     *
     * @return Empleados
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return string
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set fechaInicioLaboral
     *
     * @param CarbonDate $fechaInicioLaboral
     *
     * @return Empleados
     */
    public function setFechaInicioLaboral($fechaInicioLaboral)
    {
        $this->fechaInicioLaboral = $fechaInicioLaboral;

        return $this;
    }

    /**
     * Get fechaInicioLaboral
     *
     * @return CarbonDate
     */
    public function getFechaInicioLaboral()
    {
        return $this->fechaInicioLaboral;
    }

    /**
     * Set tipoRegimen
     *
     * @param string $tipoRegimen
     *
     * @return Empleados
     */
    public function setTipoRegimen($tipoRegimen)
    {
        $this->tipoRegimen = $tipoRegimen;

        return $this;
    }

    /**
     * Get tipoRegimen
     *
     * @return string
     */
    public function getTipoRegimen()
    {
        return $this->tipoRegimen;
    }

    /**
     * Set salario
     *
     * @param string $salario
     *
     * @return Empleados
     */
    public function setSalario($salario)
    {
        $this->salario = $salario;

        return $this;
    }

    /**
     * Get salario
     *
     * @return string
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * Set periodicidadPago
     *
     * @param string $periodicidadPago
     *
     * @return Empleados
     */
    public function setPeriodicidadPago($periodicidadPago)
    {
        $this->periodicidadPago = $periodicidadPago;

        return $this;
    }

    /**
     * Get periodicidadPago
     *
     * @return string
     */
    public function getPeriodicidadPago()
    {
        return $this->periodicidadPago;
    }

    /**
     * Set salarioDiarioIntegrado
     *
     * @param string $salarioDiarioIntegrado
     *
     * @return Empleados
     */
    public function setSalarioDiarioIntegrado($salarioDiarioIntegrado)
    {
        $this->salarioDiarioIntegrado = $salarioDiarioIntegrado;

        return $this;
    }

    /**
     * Get salarioDiarioIntegrado
     *
     * @return string
     */
    public function getSalarioDiarioIntegrado()
    {
        return $this->salarioDiarioIntegrado;
    }

    /**
     * Set clabe
     *
     * @param string $clabe
     *
     * @return Empleados
     */
    public function setClabe($clabe)
    {
        $this->clabe = $clabe;

        return $this;
    }

    /**
     * Get clabe
     *
     * @return string
     */
    public function getClabe()
    {
        return $this->clabe;
    }

    /**
     * Set banco
     *
     * @param string $banco
     *
     * @return Empleados
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Empleados
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
}
