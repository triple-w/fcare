<?php

namespace app\Models;

/**
 * UsersPerfil
 */
class UsersPerfil
{
    /**
     * @var integer
     */
    private $numeroRegimen;

    /**
     * @var string
     */
    private $nombreRegimen;

    /**
     * @var string
     */
    private $ciec;

    /**
     * @var \App\Models\Users
     */
    private $user;


    /**
     * Set numeroRegimen
     *
     * @param integer $numeroRegimen
     *
     * @return UsersPerfil
     */
    public function setNumeroRegimen($numeroRegimen)
    {
        $this->numeroRegimen = $numeroRegimen;

        return $this;
    }

    /**
     * Get numeroRegimen
     *
     * @return integer
     */
    public function getNumeroRegimen()
    {
        return $this->numeroRegimen;
    }

    /**
     * Set nombreRegimen
     *
     * @param string $nombreRegimen
     *
     * @return UsersPerfil
     */
    public function setNombreRegimen($nombreRegimen)
    {
        $this->nombreRegimen = $nombreRegimen;

        return $this;
    }

    /**
     * Get nombreRegimen
     *
     * @return string
     */
    public function getNombreRegimen()
    {
        return $this->nombreRegimen;
    }

    /**
     * Set ciec
     *
     * @param string $ciec
     *
     * @return UsersPerfil
     */
    public function setCiec($ciec)
    {
        $this->ciec = $ciec;

        return $this;
    }

    /**
     * Get ciec
     *
     * @return string
     */
    public function getCiec()
    {
        return $this->ciec;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersPerfil
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

