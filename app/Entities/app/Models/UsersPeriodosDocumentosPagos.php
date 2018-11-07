<?php

namespace app\Models;

/**
 * UsersPeriodosDocumentosPagos
 */
class UsersPeriodosDocumentosPagos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $monto;

    /**
     * @var CarbonDateTime
     */
    private $fechaPago;

    /**
     * @var \App\Models\UsersPeriodosDocumentos
     */
    private $documento;


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
}

