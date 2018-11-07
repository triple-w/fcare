<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_propuestas_documentos")
*/
class UsersPropuestasDocumentos extends UploadableEntity
{

    /**
    * @ORM\ManyToOne(targetEntity="UsersPropuestas", inversedBy="documentos")
    * @ORM\JoinColumn(name="users_propuestas_id", referencedColumnName="id", nullable=false)
    */
    private $propuesta;

    /**
     * Constructor
     */
    public function __construct(\App\Models\UsersPropuestas $propuesta = null)
    {
        $this->propuesta = $propuesta;
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
