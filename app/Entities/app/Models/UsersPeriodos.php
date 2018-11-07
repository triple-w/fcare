<?php

namespace app\Models;

/**
 * UsersPeriodos
 */
class UsersPeriodos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var CarbonDate
     */
    private $fechaInicial;

    /**
     * @var CarbonDate
     */
    private $fechaFinal;

    /**
     * @var integer
     */
    private $mes;

    /**
     * @var integer
     */
    private $anio;

    /**
     * @var string
     */
    private $estatus;

    /**
     * @var string
     */
    private $ingresoSinFactura;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $documentos;

    /**
     * @var \App\Models\Users
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechaInicial
     *
     * @param CarbonDate $fechaInicial
     *
     * @return UsersPeriodos
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    /**
     * Get fechaInicial
     *
     * @return CarbonDate
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param CarbonDate $fechaFinal
     *
     * @return UsersPeriodos
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return CarbonDate
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return UsersPeriodos
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return UsersPeriodos
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
     * Set estatus
     *
     * @param string $estatus
     *
     * @return UsersPeriodos
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
     * Set ingresoSinFactura
     *
     * @param string $ingresoSinFactura
     *
     * @return UsersPeriodos
     */
    public function setIngresoSinFactura($ingresoSinFactura)
    {
        $this->ingresoSinFactura = $ingresoSinFactura;

        return $this;
    }

    /**
     * Get ingresoSinFactura
     *
     * @return string
     */
    public function getIngresoSinFactura()
    {
        return $this->ingresoSinFactura;
    }

    /**
     * Add documento
     *
     * @param \App\Models\UsersPeriodosDocumentos $documento
     *
     * @return UsersPeriodos
     */
    public function addDocumento(\App\Models\UsersPeriodosDocumentos $documento)
    {
        $this->documentos[] = $documento;

        return $this;
    }

    /**
     * Remove documento
     *
     * @param \App\Models\UsersPeriodosDocumentos $documento
     */
    public function removeDocumento(\App\Models\UsersPeriodosDocumentos $documento)
    {
        $this->documentos->removeElement($documento);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPeriodos
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

