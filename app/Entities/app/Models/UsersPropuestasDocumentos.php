<?php

namespace app\Models;

/**
 * UsersPropuestasDocumentos
 */
class UsersPropuestasDocumentos
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \App\Models\UsersPropuestas
     */
    private $propuesta;


    /**
     * Set path
     *
     * @param string $path
     *
     * @return UsersPropuestasDocumentos
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set propuesta
     *
     * @param \App\Models\UsersPropuestas $propuesta
     *
     * @return UsersPropuestasDocumentos
     */
    public function setPropuesta(\App\Models\UsersPropuestas $propuesta)
    {
        $this->propuesta = $propuesta;

        return $this;
    }

    /**
     * Get propuesta
     *
     * @return \App\Models\UsersPropuestas
     */
    public function getPropuesta()
    {
        return $this->propuesta;
    }
}

