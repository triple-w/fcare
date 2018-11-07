<?php

namespace app\Models;

/**
 * UsersPagosContabilidad
 */
class UsersPagosContabilidad
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $idTransaccion;

    /**
     * @var string
     */
    private $authorization;

    /**
     * @var string
     */
    private $tipoPlan;

    /**
     * @var string
     */
    private $precio;

    /**
     * @var CarbonDateTime
     */
    private $fechaPago;

    /**
     * @var integer
     */
    private $descargasCompradas;

    /**
     * @var integer
     */
    private $descargasDisponibles;

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
     * Set idTransaccion
     *
     * @param string $idTransaccion
     *
     * @return UsersPagosContabilidad
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
     * @return UsersPagosContabilidad
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
     * Set tipoPlan
     *
     * @param string $tipoPlan
     *
     * @return UsersPagosContabilidad
     */
    public function setTipoPlan($tipoPlan)
    {
        $this->tipoPlan = $tipoPlan;

        return $this;
    }

    /**
     * Get tipoPlan
     *
     * @return string
     */
    public function getTipoPlan()
    {
        return $this->tipoPlan;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return UsersPagosContabilidad
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
     * @return UsersPagosContabilidad
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
     * Set descargasCompradas
     *
     * @param integer $descargasCompradas
     *
     * @return UsersPagosContabilidad
     */
    public function setDescargasCompradas($descargasCompradas)
    {
        $this->descargasCompradas = $descargasCompradas;

        return $this;
    }

    /**
     * Get descargasCompradas
     *
     * @return integer
     */
    public function getDescargasCompradas()
    {
        return $this->descargasCompradas;
    }

    /**
     * Set descargasDisponibles
     *
     * @param integer $descargasDisponibles
     *
     * @return UsersPagosContabilidad
     */
    public function setDescargasDisponibles($descargasDisponibles)
    {
        $this->descargasDisponibles = $descargasDisponibles;

        return $this;
    }

    /**
     * Get descargasDisponibles
     *
     * @return integer
     */
    public function getDescargasDisponibles()
    {
        return $this->descargasDisponibles;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPagosContabilidad
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

