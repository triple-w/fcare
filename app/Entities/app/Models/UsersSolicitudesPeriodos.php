<?php

namespace app\Models;

/**
 * UsersSolicitudesPeriodos
 */
class UsersSolicitudesPeriodos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var CarbonDate
     */
    private $fechaSolicitud;

    /**
     * @var integer
     */
    private $meses;

    /**
     * @var array
     */
    private $mesesSolicitud;

    /**
     * @var array
     */
    private $aniosSolicitud;

    /**
     * @var boolean
     */
    private $revisado;

    /**
     * @var \App\Models\Users
     */
    private $user;


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
     * Set fechaSolicitud
     *
     * @param CarbonDate $fechaSolicitud
     *
     * @return UsersSolicitudesPeriodos
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return CarbonDate
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set meses
     *
     * @param integer $meses
     *
     * @return UsersSolicitudesPeriodos
     */
    public function setMeses($meses)
    {
        $this->meses = $meses;

        return $this;
    }

    /**
     * Get meses
     *
     * @return integer
     */
    public function getMeses()
    {
        return $this->meses;
    }

    /**
     * Set mesesSolicitud
     *
     * @param array $mesesSolicitud
     *
     * @return UsersSolicitudesPeriodos
     */
    public function setMesesSolicitud($mesesSolicitud)
    {
        $this->mesesSolicitud = $mesesSolicitud;

        return $this;
    }

    /**
     * Get mesesSolicitud
     *
     * @return array
     */
    public function getMesesSolicitud()
    {
        return $this->mesesSolicitud;
    }

    /**
     * Set aniosSolicitud
     *
     * @param array $aniosSolicitud
     *
     * @return UsersSolicitudesPeriodos
     */
    public function setAniosSolicitud($aniosSolicitud)
    {
        $this->aniosSolicitud = $aniosSolicitud;

        return $this;
    }

    /**
     * Get aniosSolicitud
     *
     * @return array
     */
    public function getAniosSolicitud()
    {
        return $this->aniosSolicitud;
    }

    /**
     * Set revisado
     *
     * @param boolean $revisado
     *
     * @return UsersSolicitudesPeriodos
     */
    public function setRevisado($revisado)
    {
        $this->revisado = $revisado;

        return $this;
    }

    /**
     * Get revisado
     *
     * @return boolean
     */
    public function getRevisado()
    {
        return $this->revisado;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersSolicitudesPeriodos
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

