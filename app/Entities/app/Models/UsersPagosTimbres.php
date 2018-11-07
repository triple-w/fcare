<?php

namespace app\Models;

/**
 * UsersPagosTimbres
 */
class UsersPagosTimbres
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
    private $precio;

    /**
     * @var string
     */
    private $monto;

    /**
     * @var CarbonDateTime
     */
    private $fechaPago;

    /**
     * @var \App\Models\Users
     */
    private $user;

    /**
     * @var \App\Models\TimbresMovs
     */
    private $mov;


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
     * @return UsersPagosTimbres
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
     * @return UsersPagosTimbres
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
     * Set precio
     *
     * @param string $precio
     *
     * @return UsersPagosTimbres
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
     * Set monto
     *
     * @param string $monto
     *
     * @return UsersPagosTimbres
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
     * @return UsersPagosTimbres
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPagosTimbres
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

    /**
     * Set mov
     *
     * @param \App\Models\TimbresMovs $mov
     *
     * @return UsersPagosTimbres
     */
    public function setMov(\App\Models\TimbresMovs $mov)
    {
        $this->mov = $mov;

        return $this;
    }

    /**
     * Get mov
     *
     * @return \App\Models\TimbresMovs
     */
    public function getMov()
    {
        return $this->mov;
    }
}

