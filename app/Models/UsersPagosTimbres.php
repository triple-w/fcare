<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_pagos_timbres")
*/
class UsersPagosTimbres extends DoctrineEntity {

	private $rules = [
	];

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=50,name="id_transaccion",nullable=false)
    */
    private $idTransaccion;

    /**
    * @ORM\Column(type="string",length=50,name="authorization",nullable=false)
    */
    private $authorization;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="precio",nullable=false)
    */
    private $precio;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="monto",nullable=false)
    */
    private $monto;

    /**
     * @ORM\Column(type="CarbonDateTime",name="fecha_pago",nullable=true)
     */
    private $fechaPago;        

    /**
    * @ORM\Column(type="boolean",name="requiere_factura",nullable=false)
    */
    private $requiereFactura;

    /**
    * @ORM\Column(type="string",length=15,name="status_factura",nullable=true)
    */
    private $statusFactura;

    /**

    * @ORM\ManyToOne(targetEntity="Users", inversedBy="pagosTimbres")

    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)

    */

    private $user;

    /**
    * @ORM\OneToOne(targetEntity="TimbresMovs", inversedBy="pago")
    * @ORM\JoinColumn(name="timbres_movs_id", referencedColumnName="id", nullable=false)
    */
    private $mov;

    public function __construct(\App\Models\Users $user = null, \App\Models\TimbresMovs $mov) {
        $this->user = $user;
        $this->mov = $mov;
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
     * @return UsersPagosTimbres
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
     * @return UsersPagosTimbres
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
     * Set precio
     *
     * @param string $precio
     *
     * @return UsersPagosTimbres
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
     * Set fechaPago
     *
     * @param CarbonDateTime $fechaPago
     *
     * @return UsersPagosTimbres
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPagosTimbres
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
     * Set monto
     *
     * @param string $monto
     *
     * @return UsersPagosTimbres
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set mov
     *
     * @param \App\Models\TimbresMovs $mov
     *
     * @return UsersPagosTimbres
     */
    public function setMov(\App\Models\TimbresMovs $mov)
    {
        $this->mov = $mov;

        return $this;
    }

    /**
     * Get mov
     *
     * @return \App\Models\TimbresMovs
     */
    public function getMov()
    {
        return $this->mov;
    }

    /**
     * Set requiereFactura
     *
     * @param boolean $requiereFactura
     *
     * @return UsersPagosTimbres
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
     * @return UsersPagosTimbres
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
}
