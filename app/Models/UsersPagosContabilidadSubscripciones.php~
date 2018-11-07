<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\UsersPagosContabilidadSubscripcionesRepository")
* @ORM\Table(name="users_pagos_contabilidad_subscripciones")
*/
class UsersPagosContabilidadSubscripciones extends DoctrineEntity {

	private $rules = [
	];

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=50,name="id_subscripcion",nullable=false)
    */
    private $idSubscripcion;

    /**
    * @ORM\Column(type="string",length=50,name="id_plan",nullable=false)
    */
    private $idPlan;

    /**
    * @ORM\Column(type="string",length=50,name="id_card",nullable=false)
    */
    private $idCard;

    /**
    * @ORM\Column(type="string",length=50,name="id_customer",nullable=false)
    */
    private $idCustomer;

    /**
    * @ORM\Column(type="string",length=15,name="estatus",nullable=false)
    */
    private $estatus;

    /**
    * @ORM\OneToOne(targetEntity="UsersPagosContabilidad", inversedBy="subscripcion")
    * @ORM\JoinColumn(name="users_pagos_contabilidad_id", referencedColumnName="id", nullable=false)
    */
    private $pagoContabilidad;

    public function __construct(\App\Models\UsersPagosContabilidad $pagoContabilidad) {
        $this->pagoContabilidad = $pagoContabilidad;
        $this->estatus = 'ACTIVA';
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
     * Set idSubscripcion
     *
     * @param string $idSubscripcion
     *
     * @return UsersPagosContabilidadSubscripciones
     */
    public function setIdSubscripcion($idSubscripcion)
    {
        $this->idSubscripcion = $idSubscripcion;

        return $this;
    }

    /**
     * Get idSubscripcion
     *
     * @return string
     */
    public function getIdSubscripcion()
    {
        return $this->idSubscripcion;
    }

    /**
     * Set idPlan
     *
     * @param string $idPlan
     *
     * @return UsersPagosContabilidadSubscripciones
     */
    public function setIdPlan($idPlan)
    {
        $this->idPlan = $idPlan;

        return $this;
    }

    /**
     * Get idPlan
     *
     * @return string
     */
    public function getIdPlan()
    {
        return $this->idPlan;
    }

    /**
     * Set idCustomer
     *
     * @param string $idCustomer
     *
     * @return UsersPagosContabilidadSubscripciones
     */
    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;

        return $this;
    }

    /**
     * Get idCustomer
     *
     * @return string
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return UsersPagosContabilidadSubscripciones
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
     * Set pagoContabilidad
     *
     * @param \App\Models\UsersPagosContabilidad $pagoContabilidad
     *
     * @return UsersPagosContabilidadSubscripciones
     */
    public function setPagoContabilidad(\App\Models\UsersPagosContabilidad $pagoContabilidad)
    {
        $this->pagoContabilidad = $pagoContabilidad;

        return $this;
    }

    /**
     * Get pagoContabilidad
     *
     * @return \App\Models\UsersPagosContabilidad
     */
    public function getPagoContabilidad()
    {
        return $this->pagoContabilidad;
    }

    /**
     * Set idCard
     *
     * @param string $idCard
     *
     * @return UsersPagosContabilidadSubscripciones
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * Get idCard
     *
     * @return string
     */
    public function getIdCard()
    {
        return $this->idCard;
    }
}
