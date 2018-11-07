<?php

namespace app\Models;

/**
 * FacturasComplementos
 */
class FacturasComplementos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $solicitudTimbre;

    /**
     * @var string
     */
    private $xml;

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
     * Set solicitudTimbre
     *
     * @param string $solicitudTimbre
     *
     * @return FacturasComplementos
     */
    public function setSolicitudTimbre($solicitudTimbre)
    {
        $this->solicitudTimbre = $solicitudTimbre;

        return $this;
    }

    /**
     * Get solicitudTimbre
     *
     * @return string
     */
    public function getSolicitudTimbre()
    {
        return $this->solicitudTimbre;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return FacturasComplementos
     */
    public function setXml($xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return FacturasComplementos
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

