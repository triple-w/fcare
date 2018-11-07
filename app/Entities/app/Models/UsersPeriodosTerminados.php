<?php

namespace app\Models;

/**
 * UsersPeriodosTerminados
 */
class UsersPeriodosTerminados
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var CarbonDate
     */
    private $fechaTerminado;

    /**
     * @var integer
     */
    private $mes;

    /**
     * @var integer
     */
    private $anio;

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
     * Set fechaTerminado
     *
     * @param CarbonDate $fechaTerminado
     *
     * @return UsersPeriodosTerminados
     */
    public function setFechaTerminado($fechaTerminado)
    {
        $this->fechaTerminado = $fechaTerminado;

        return $this;
    }

    /**
     * Get fechaTerminado
     *
     * @return CarbonDate
     */
    public function getFechaTerminado()
    {
        return $this->fechaTerminado;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return UsersPeriodosTerminados
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
     * @return UsersPeriodosTerminados
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
     * Set revisado
     *
     * @param boolean $revisado
     *
     * @return UsersPeriodosTerminados
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
     * @return UsersPeriodosTerminados
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

