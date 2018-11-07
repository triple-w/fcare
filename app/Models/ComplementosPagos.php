<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\ComplementosPagosRepository")
* @ORM\Table(name="complementos_pagos")
*/
class ComplementosPagos extends DoctrineEntity {

    private $rules = [
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Complementos", inversedBy="pagos")
    * @ORM\JoinColumn(name="users_complementos_id", referencedColumnName="id", nullable=false)
    */
    private $complemento;

    /**
    * @ORM\Column(type="string",length=150,name="documento_id",nullable=false)
    */
    private $documentoId;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha_pago",nullable=true)
    */
    private $fechaPago;

    /**
     * @ORM\Column(type="integer",name="parcialidad",nullable=true)
     */
    private $parcialidad;

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="saldo_anterior",nullable=false)
    */
    private $saldoAnterior;
    
    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="monto_pago",nullable=false)
    */
    private $montoPago;
    
    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="saldo_insoluto",nullable=false)
    */
    private $saldoInsoluto;
    

    /**
     * Constructor
     */
    public function __construct(\App\Models\Complementos $complemento = null)
    {
        $this->complemento = $complemento;
    }

    /**
     * Set complemento
     *
     * @param \App\Models\Complementos $complemento
     *
     * @return ComplementosPagos
     */
    public function setComplemento(\App\Models\Complementos $complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return \App\Models\Complementos
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set documentoId
     *
     * @param string $documentoId
     *
     * @return ComplementosPagos
     */
    public function setDocumentoId($documentoId)
    {
        $this->documentoId = $documentoId;

        return $this;
    }

    /**
     * Get documentoId
     *
     * @return string
     */
    public function getDocumentoId()
    {
        return $this->documentoId;
    }

    /**
     * Set fechaPago
     *
     * @param CarbonDate $fechaPago
     *
     * @return ComplementosPagos
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return CarbonDate
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set parcialidad
     * 
     * @param int $parcialidad
     * 
     * @return ComplementosPagos
     */
    public function setParcialidad($parcialidad)
    {
        $this->parcialidad = $parcialidad;

        return $this;
    }

    /**
     * Get parcialidad
     * 
     * @return int
     */
    public function getParcialidad()
    {
        return $this->parcialidad;
    }

    /**
     * Set saldoAnterior
     *
     * @param string $saldoAnterior
     *
     * @return ComplementosPagos
     */
    public function setSaldoAnterior($saldoAnterior)
    {
        $this->saldoAnterior = $saldoAnterior;

        return $this;
    }

    /**
     * Get saldoAnterior
     *
     * @return string
     */
    public function getSaldoAnterior()
    {
        return $this->saldoAnterior;
    }

    /**
     * Set montoPago
     *
     * @param string $montoPago
     *
     * @return ComplementosPagos
     */
    public function setMontoPago($montoPago)
    {
        $this->montoPago = $montoPago;

        return $this;
    }

    /**
     * Get montoPago
     *
     * @return string
     */
    public function getMontoPago()
    {
        return $this->montoPago;
    }

    /**
     * Set saldoInsoluto
     *
     * @param string $saldoInsoluto
     *
     * @return ComplementosPagos
     */
    public function setSaldoInsoluto($saldoInsoluto)
    {
        $this->saldoInsoluto = $saldoInsoluto;

        return $this;
    }

    /**
     * Get saldoInsoluto
     *
     * @return string
     */
    public function getSaldoInsoluto()
    {
        return $this->saldoInsoluto;
    }
}
