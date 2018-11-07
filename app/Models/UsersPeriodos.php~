<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Models\Repositories\UsersPeriodosRepository")
* @ORM\Table(name="users_periodos", indexes={
*   @ORM\Index(name="INDX_ESTATUS", columns={"estatus"})
* })
*/
class UsersPeriodos extends DoctrineEntity
{

    const NUEVO = 'NUEVO';
    const COMPLETO = 'COMPLETO';

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="CarbonDate",name="fecha_inicial",nullable=false)
     */
    private $fechaInicial;

    /**
     * @ORM\Column(type="CarbonDate",name="fecha_final",nullable=false)
     */
    private $fechaFinal;

    /**
    * @ORM\Column(type="integer",name="mes",nullable=false)
    */
    private $mes;

    /**
    * @ORM\Column(type="integer",name="anio",nullable=false)
    */
    private $anio;

    /**
    * @ORM\Column(type="string",length=15,name="estatus",nullable=false)
    */
    private $estatus;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="ingreso_sin_factura",nullable=true)
    */
    private $ingresoSinFactura;

    /**
    * @ORM\OneToMany(targetEntity="UsersPeriodosDocumentos", mappedBy="periodo", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EXTRA_LAZY")
    */
    private $documentos;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="periodos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;
        $this->estatus = self::NUEVO;

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
     * @param CarbonDateTime $fechaInicial
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
     * @return CarbonDateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * Set fechaFinal
     *
     * @param CarbonDateTime $fechaFinal
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
     * @return CarbonDateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
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
}
