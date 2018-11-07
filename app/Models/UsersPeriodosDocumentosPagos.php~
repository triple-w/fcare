<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\UsersPeriodosDocumentosPagosRepository")
* @ORM\Table(name="users_periodos_documentos_pagos")
*/
class UsersPeriodosDocumentosPagos extends DoctrineEntity
{

    public static function getDeducciones() {
        return [
            'TOTAL' => 'Total',
            'PARCIAL' => 'Parcial',
            'NO_DEDUCIBLE' => 'No Deducible',
            'NO_CONSIDERAR' => 'No Considerar',
        ];
    }

    public static function getTiposGastos() {
        return [
            'GASTO_EN_GENERAL' => 'Gasto en General',
            'ADQUI_MERCANCIAS' => 'Adquisición de Mercancias',
            'INVERSIONES' => 'Inversiones',
            'NO_CONSIDERAR' => 'No Considerar',
        ];
    }

    public static function getClasificaciones() {
        return [
            'PAGADO' => 'Pagado',
            'PAGADO_PARCIAL' => 'Pagado Parcial',
        ];
    }

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal",name="monto",precision=10,scale=2,nullable=false)
     */
    private $monto;

    /**
     * @ORM\Column(type="CarbonDateTime",name="fecha_pago",nullable=false)
     */
    private $fechaPago;

    /**
    * @ORM\Column(type="string",length=20,name="deduccion",nullable=false)
    */
    private $deduccion;

    /**
    * @ORM\Column(type="string",length=20,name="tipo_gasto",nullable=false)
    */
    private $tipoGasto;

    /**
    * @ORM\Column(type="string",length=20,name="clasificacion",nullable=false)
    */
    private $clasificacion;

    /**
    * @ORM\ManyToOne(targetEntity="UsersPeriodosDocumentos", inversedBy="pagos")
    * @ORM\JoinColumn(name="users_periodos__documentos_id", referencedColumnName="id", nullable=false)
    */
    private $documento;

    public function __construct(\App\Models\UsersPeriodosDocumentos $documento = null) {
        $this->documento = $documento;
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
     * Set monto
     *
     * @param string $monto
     *
     * @return UsersPeriodosDocumentosPagos
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
     * Set fechaPago
     *
     * @param CarbonDateTime $fechaPago
     *
     * @return UsersPeriodosDocumentosPagos
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
     * Set documento
     *
     * @param \App\Models\UsersPeriodosDocumentos $documento
     *
     * @return UsersPeriodosDocumentosPagos
     */
    public function setDocumento(\App\Models\UsersPeriodosDocumentos $documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return \App\Models\UsersPeriodosDocumentos
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set deduccion
     *
     * @param string $deduccion
     *
     * @return UsersPeriodosDocumentosPagos
     */
    public function setDeduccion($deduccion)
    {
        $this->deduccion = $deduccion;

        return $this;
    }

    /**
     * Get deduccion
     *
     * @return string
     */
    public function getDeduccion()
    {
        return $this->deduccion;
    }

    /**
     * Set tipoGasto
     *
     * @param string $tipoGasto
     *
     * @return UsersPeriodosDocumentosPagos
     */
    public function setTipoGasto($tipoGasto)
    {
        $this->tipoGasto = $tipoGasto;

        return $this;
    }

    /**
     * Get tipoGasto
     *
     * @return string
     */
    public function getTipoGasto()
    {
        return $this->tipoGasto;
    }

    /**
     * Set clasificacion
     *
     * @param string $clasificacion
     *
     * @return UsersPeriodosDocumentosPagos
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return string
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }
}
