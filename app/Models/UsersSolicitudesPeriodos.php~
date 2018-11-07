<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_solicitudes_periodos")
*/
class UsersSolicitudesPeriodos extends DoctrineEntity
{

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="CarbonDate",name="fecha_solicitud",nullable=false)
     */
    private $fechaSolicitud;

    /**
     * @ORM\Column(type="integer",name="meses",nullable=false)
     */
    private $meses;

    /**
     * @ORM\Column(type="array",name="meses_solicitud",nullable=false)
     */
    private $mesesSolicitud;

    /**
     * @ORM\Column(type="array",name="anios_solicitud",nullable=false)
     */
    private $aniosSolicitud;

    /**
     * @ORM\Column(type="boolean",name="revisado",nullable=false)
     */
    private $revisado;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="solicitudesPeriodos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;
        $this->fechaSolicitud = \Carbon\Carbon::now();
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
}
