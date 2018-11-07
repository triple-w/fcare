<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="nominas_otros_pagos")
*/
class NominasOtrosPagos extends DoctrineEntity {

	private $rules = [
	];

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=15,name="tipo_otro_pago",nullable=false)
    */
    private $tipoOtroPago;

    /**
    * @ORM\Column(type="string",length=15,name="clave",nullable=false)
    */
    private $clave;

    /**
    * @ORM\Column(type="string",length=90,name="concepto",nullable=false)
    */
    private $concepto;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="importe",nullable=false)
    */
    private $importe;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="subsidio_causado",nullable=false)
    */
    private $subsidioCausado;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="saldo_favor",nullable=false)
    */
    private $saldoFavor;

    /**
    * @ORM\Column(type="integer",name="anio",nullable=false)
    */
    private $anio;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="remanente",nullable=false)
    */
    private $remanente;

    /**
    * @ORM\ManyToOne(targetEntity="Nominas", inversedBy="otrosPagos")
    * @ORM\JoinColumn(name="nominas_id", referencedColumnName="id", nullable=false)
    */
    private $nomina;

    public function __construct(\App\Models\Nominas $nomina = null) {
        $this->nomina = $nomina;
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
     * Set tipoOtroPago
     *
     * @param string $tipoOtroPago
     *
     * @return NominasOtrosPagos
     */
    public function setTipoOtroPago($tipoOtroPago)
    {
        $this->tipoOtroPago = $tipoOtroPago;

        return $this;
    }

    /**
     * Get tipoOtroPago
     *
     * @return string
     */
    public function getTipoOtroPago()
    {
        return $this->tipoOtroPago;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return NominasOtrosPagos
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return NominasOtrosPagos
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return NominasOtrosPagos
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set subsidioCausado
     *
     * @param string $subsidioCausado
     *
     * @return NominasOtrosPagos
     */
    public function setSubsidioCausado($subsidioCausado)
    {
        $this->subsidioCausado = $subsidioCausado;

        return $this;
    }

    /**
     * Get subsidioCausado
     *
     * @return string
     */
    public function getSubsidioCausado()
    {
        return $this->subsidioCausado;
    }

    /**
     * Set saldoFavor
     *
     * @param string $saldoFavor
     *
     * @return NominasOtrosPagos
     */
    public function setSaldoFavor($saldoFavor)
    {
        $this->saldoFavor = $saldoFavor;

        return $this;
    }

    /**
     * Get saldoFavor
     *
     * @return string
     */
    public function getSaldoFavor()
    {
        return $this->saldoFavor;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return NominasOtrosPagos
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set remanente
     *
     * @param string $remanente
     *
     * @return NominasOtrosPagos
     */
    public function setRemanente($remanente)
    {
        $this->remanente = $remanente;

        return $this;
    }

    /**
     * Get remanente
     *
     * @return string
     */
    public function getRemanente()
    {
        return $this->remanente;
    }

    /**
     * Set nomina
     *
     * @param \App\Models\Nominas $nomina
     *
     * @return NominasOtrosPagos
     */
    public function setNomina(\App\Models\Nominas $nomina)
    {
        $this->nomina = $nomina;

        return $this;
    }

    /**
     * Get nomina
     *
     * @return \App\Models\Nominas
     */
    public function getNomina()
    {
        return $this->nomina;
    }
}
