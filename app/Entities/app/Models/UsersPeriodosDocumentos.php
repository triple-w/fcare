<?php

namespace app\Models;

/**
 * UsersPeriodosDocumentos
 */
class UsersPeriodosDocumentos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $estatus;

    /**
     * @var boolean
     */
    private $cancelado;

    /**
     * @var array
     */
    private $datos;

    /**
     * @var string
     */
    private $xml;

    /**
     * @var \App\Models\UsersPeriodos
     */
    private $periodo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pagos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UsersPeriodosDocumentos
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
     * Set estatus
     *
     * @param string $estatus
     *
     * @return UsersPeriodosDocumentos
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
     * Set cancelado
     *
     * @param boolean $cancelado
     *
     * @return UsersPeriodosDocumentos
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    /**
     * Get cancelado
     *
     * @return boolean
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set datos
     *
     * @param array $datos
     *
     * @return UsersPeriodosDocumentos
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return UsersPeriodosDocumentos
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
     * Set periodo
     *
     * @param \App\Models\UsersPeriodos $periodo
     *
     * @return UsersPeriodosDocumentos
     */
    public function setPeriodo(\App\Models\UsersPeriodos $periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \App\Models\UsersPeriodos
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Add pago
     *
     * @param \App\Models\UsersPeriodosDocumentosPagos $pago
     *
     * @return UsersPeriodosDocumentos
     */
    public function addPago(\App\Models\UsersPeriodosDocumentosPagos $pago)
    {
        $this->pagos[] = $pago;

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \App\Models\UsersPeriodosDocumentosPagos $pago
     */
    public function removePago(\App\Models\UsersPeriodosDocumentosPagos $pago)
    {
        $this->pagos->removeElement($pago);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos()
    {
        return $this->pagos;
    }
}

