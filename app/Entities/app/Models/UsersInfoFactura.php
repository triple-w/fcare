<?php

namespace app\Models;

/**
 * UsersInfoFactura
 */
class UsersInfoFactura
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $password;

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
     * Set password
     *
     * @param string $password
     *
     * @return UsersInfoFactura
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersInfoFactura
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
     * @param \App\Models\UsersInfoFacturaDocumentos $documento
     *
     * @return UsersInfoFactura
     */
    public function addDocumento(\App\Models\UsersInfoFacturaDocumentos $documento)
    {
        $this->documentos[] = $documento;

        return $this;
    }

    /**
     * Remove documento
     *
     * @param \App\Models\UsersInfoFacturaDocumentos $documento
     */
    public function removeDocumento(\App\Models\UsersInfoFacturaDocumentos $documento)
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

