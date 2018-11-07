<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_propuestas", indexes={
*   @ORM\Index(name="INDX_FECHA", columns={"mes", "anio"})
* })
*/
class UsersPropuestas extends DoctrineEntity
{

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="mes",nullable=false)
     */
    private $mes;

    /**
     * @ORM\Column(type="integer",name="anio",nullable=false)
     */
    private $anio;

    /**
    * @ORM\Column(type="string",length=500,name="propuesta",nullable=true)
    */
    private $propuesta;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="propuestas")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="UsersPropuestasDocumentos", mappedBy="propuesta", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $documentos;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;
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
     * Set mes
     *
     * @param integer $mes
     *
     * @return UsersPropuestas
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
     * @return UsersPropuestas
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
     * Set propuesta
     *
     * @param string $propuesta
     *
     * @return UsersPropuestas
     */
    public function setPropuesta($propuesta)
    {
        $this->propuesta = $propuesta;

        return $this;
    }

    /**
     * Get propuesta
     *
     * @return string
     */
    public function getPropuesta()
    {
        return $this->propuesta;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPropuestas
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
     * Add documento
     *
     * @param \App\Models\UsersPropuestasDocumentos $documento
     *
     * @return UsersPropuestas
     */
    public function addDocumento(\App\Models\UsersPropuestasDocumentos $documento)
    {
        $this->documentos[] = $documento;

        return $this;
    }

    /**
     * Remove documento
     *
     * @param \App\Models\UsersPropuestasDocumentos $documento
     */
    public function removeDocumento(\App\Models\UsersPropuestasDocumentos $documento)
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
}
