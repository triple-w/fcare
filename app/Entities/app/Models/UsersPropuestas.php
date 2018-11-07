<?php

namespace app\Models;

/**
 * UsersPropuestas
 */
class UsersPropuestas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $mes;

    /**
     * @var integer
     */
    private $anio;

    /**
     * @var string
     */
    private $propuesta;

    /**
     * @var \App\Models\Users
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $documentos;

    /**
     * Constructor
     */
    public function __construct()
    {
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

