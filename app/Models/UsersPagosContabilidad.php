<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\UsersPagosContabilidadRepository")
* @ORM\Table(name="users_pagos_contabilidad")
*/
class UsersPagosContabilidad extends DoctrineEntity {

    private $rules = [
    ];

    public static function getTiposPlanes($user = null) {
        if (empty($user)) {
            $user = \Auth::user();
        }

        if ($user->getPerfil()->getNumeroRegimen() === 621) {
            return [
                '1_MESES' => '1 Mes, $499.00',
                '3_MESES' => '3 Meses, $1,347.30 10%',
                '6_MESES' => '6 Meses, $2,544.90 15%',
                '12_MESES' => '12 Meses, $4,790.40 20%'
            ];
        } else {
            return [
                '1_MESES' => '1 Mes, $599.00',
                '3_MESES' => '3 Meses, $1,617.30 10%',
                '6_MESES' => '6 Meses, $3,054.90 15%',
                '12_MESES' => '12 Meses, $5,750.40 20%'
            ];
        }
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=50,name="id_transaccion",nullable=true)
    */
    private $idTransaccion;

    /**
    * @ORM\Column(type="string",length=50,name="authorization",nullable=true)
    */
    private $authorization;

    /**
    * @ORM\Column(type="string",length=15,name="tipo_plan",nullable=true)
    */
    private $tipoPlan;

    /**
    * @ORM\Column(type="string",length=15,name="tipo",nullable=false)
    */
    private $tipo;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="precio",nullable=false)
    */
    private $precio;

    /**
    * @ORM\Column(type="string",length=15,name="tipo_plan_nuevo",nullable=true)
    */
    private $tipoPlanNuevo;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="precio_nuevo",nullable=true)
    */
    private $precioNuevo;

    /**
    * @ORM\Column(type="string",length=15,name="estatus_nuevo",nullable=true)
    */
    private $estatusNuevo;

    /**
     * @ORM\Column(type="CarbonDateTime",name="fecha_pago",nullable=false)
     */
    private $fechaPago;        

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha_termino",nullable=true)
    */
    private $fechaTermino;        

    /**
    * @ORM\Column(type="integer",name="descargas_compradas",nullable=false)
    */
    private $descargasCompradas;

    /**
    * @ORM\Column(type="integer",name="descargas_disponibles",nullable=false)
    */
    private $descargasDisponibles;

    /**
    * @ORM\Column(type="boolean",name="requiere_factura",nullable=false)
    */
    private $requiereFactura;

    /**
    * @ORM\Column(type="string",length=15,name="status_factura",nullable=true)
    */
    private $statusFactura;

    /**
    * @ORM\Column(type="text",name="xml",nullable=true)
    */
    private $xml;

    /**
    * @ORM\OneToOne(targetEntity="UsersPagosContabilidadSubscripciones", mappedBy="pagoContabilidad", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $subscripcion;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="pagosContabilidad")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
        $this->requiereFactura = false;

        $this->fechaPago = \Carbon\Carbon::now();
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
     * Set idTransaccion
     *
     * @param string $idTransaccion
     *
     * @return UsersPagosContabilidad
     */
    public function setIdTransaccion($idTransaccion)
    {
        $this->idTransaccion = $idTransaccion;

        return $this;
    }

    /**
     * Get idTransaccion
     *
     * @return string
     */
    public function getIdTransaccion()
    {
        return $this->idTransaccion;
    }

    /**
     * Set authorization
     *
     * @param string $authorization
     *
     * @return UsersPagosContabilidad
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;

        return $this;
    }

    /**
     * Get authorization
     *
     * @return string
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPagosContabilidad
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
     * Set fechaPago
     *
     * @param CarbonDateTime $fechaPago
     *
     * @return UsersPagosContabilidad
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return CarbonDateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set tipoPlan
     *
     * @param string $tipoPlan
     *
     * @return UsersPagosContabilidad
     */
    public function setTipoPlan($tipoPlan)
    {
        $this->tipoPlan = $tipoPlan;

        return $this;
    }

    /**
     * Get tipoPlan
     *
     * @return string
     */
    public function getTipoPlan()
    {
        return $this->tipoPlan;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return UsersPagosContabilidad
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set descargasDisponibles
     *
     * @param integer $descargasDisponibles
     *
     * @return UsersPagosContabilidad
     */
    public function setDescargasDisponibles($descargasDisponibles)
    {
        $this->descargasDisponibles = $descargasDisponibles;

        return $this;
    }

    /**
     * Get descargasDisponibles
     *
     * @return integer
     */
    public function getDescargasDisponibles()
    {
        return $this->descargasDisponibles;
    }

    /**
     * Set descargasCompradas
     *
     * @param integer $descargasCompradas
     *
     * @return UsersPagosContabilidad
     */
    public function setDescargasCompradas($descargasCompradas)
    {
        $this->descargasCompradas = $descargasCompradas;

        return $this;
    }

    /**
     * Get descargasCompradas
     *
     * @return integer
     */
    public function getDescargasCompradas()
    {
        return $this->descargasCompradas;
    }

    /**
     * Set subscripcion
     *
     * @param \App\Models\UsersPagosContabilidadSubscripciones $subscripcion
     *
     * @return UsersPagosContabilidad
     */
    public function setSubscripcion(\App\Models\UsersPagosContabilidadSubscripciones $subscripcion = null)
    {
        $this->subscripcion = $subscripcion;

        return $this;
    }

    /**
     * Get subscripcion
     *
     * @return \App\Models\UsersPagosContabilidadSubscripciones
     */
    public function getSubscripcion()
    {
        return $this->subscripcion;
    }

    /**
     * Set requiereFactura
     *
     * @param boolean $requiereFactura
     *
     * @return UsersPagosContabilidad
     */
    public function setRequiereFactura($requiereFactura)
    {
        $this->requiereFactura = $requiereFactura;

        return $this;
    }

    /**
     * Get requiereFactura
     *
     * @return boolean
     */
    public function getRequiereFactura()
    {
        return $this->requiereFactura;
    }

    /**
     * Set statusFactura
     *
     * @param string $statusFactura
     *
     * @return UsersPagosContabilidad
     */
    public function setStatusFactura($statusFactura)
    {
        $this->statusFactura = $statusFactura;

        return $this;
    }

    /**
     * Get statusFactura
     *
     * @return string
     */
    public function getStatusFactura()
    {
        return $this->statusFactura;
    }

    /**
     * Set tipoPlanAnterior
     *
     * @param string $tipoPlanAnterior
     *
     * @return UsersPagosContabilidad
     */
    public function setTipoPlanNuevo($tipoPlanNuevo)
    {
        $this->tipoPlanNuevo = $tipoPlanNuevo;

        return $this;
    }

    /**
     * Get tipoPlanAnterior
     *
     * @return string
     */
    public function getTipoPlanNuevo()
    {
        return $this->tipoPlanNuevo;
    }

    /**
     * Set precioAnterior
     *
     * @param string $precioAnterior
     *
     * @return UsersPagosContabilidad
     */
    public function setPrecioNuevo($precioNuevo)
    {
        $this->precioNuevo = $precioNuevo;

        return $this;
    }

    /**
     * Get precioAnterior
     *
     * @return string
     */
    public function getPrecioNuevo()
    {
        return $this->precioNuevo;
    }

    /**
     * Set estatusNuevo
     *
     * @param boolean $estatusNuevo
     *
     * @return UsersPagosContabilidad
     */
    public function setEstatusNuevo($estatusNuevo)
    {
        $this->estatusNuevo = $estatusNuevo;

        return $this;
    }

    /**
     * Get estatusNuevo
     *
     * @return boolean
     */
    public function getEstatusNuevo()
    {
        return $this->estatusNuevo;
    }

    /**
     * Set fechaTermino
     *
     * @param CarbonDateTime $fechaTermino
     *
     * @return UsersPagosContabilidad
     */
    public function setFechaTermino($fechaTermino)
    {
        $this->fechaTermino = $fechaTermino;

        return $this;
    }

    /**
     * Get fechaTermino
     *
     * @return CarbonDateTime
     */
    public function getFechaTermino()
    {
        return $this->fechaTermino;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UsersPagosContabilidad
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return UsersPagosContabilidad
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
}
