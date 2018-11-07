<?php

namespace app\Models;

/**
 * UsersSolicitudesTerminados
 */
class UsersSolicitudesTerminados
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
     * @return UsersSolicitudesTerminados
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
     * Set revisado
     *
     * @param boolean $revisado
     *
     * @return UsersSolicitudesTerminados
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
     * @return UsersSolicitudesTerminados
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

