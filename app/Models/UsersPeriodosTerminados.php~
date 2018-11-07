<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Models\Repositories\UsersPeriodosTerminadosRepository")
* @ORM\Table(name="users_periodos_terminados")
*/
class UsersPeriodosTerminados extends DoctrineEntity
{

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="CarbonDate",name="fecha_terminado",nullable=false)
     */
    private $fechaTerminado;

    /**
    * @ORM\Column(type="integer",name="mes",nullable=false)
    */
    private $mes;

    /**
    * @ORM\Column(type="integer",name="anio",nullable=false)
    */
    private $anio;

    /**
     * @ORM\Column(type="boolean",name="revisado",nullable=false)
     */
    private $revisado;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="periodosTerminados")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;
        $this->fechaTerminado = \Carbon\Carbon::now();
        $this->revisado = false;
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
}
