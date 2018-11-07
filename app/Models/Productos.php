<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="productos")
*/
class Productos extends InfoProductos {

    private $rules = [
    ];

    /**
    * @ORM\ManyToOne(targetEntity="ClaveProdServ", inversedBy="productos")
    * @ORM\JoinColumn(name="clave_prod_serv_id", referencedColumnName="id", nullable=false)
    */
    private $claveProdServ;

    /**
    * @ORM\ManyToOne(targetEntity="ClaveUnidad", inversedBy="productos")
    * @ORM\JoinColumn(name="clave_unidad_id", referencedColumnName="id", nullable=false)
    */
    private $claveUnidad;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="productos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Productos
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
     * Set claveProdServ
     *
     * @param \App\Models\ClaveProdServ $claveProdServ
     *
     * @return Productos
     */
    public function setClaveProdServ(\App\Models\ClaveProdServ $claveProdServ)
    {
        $this->claveProdServ = $claveProdServ;

        return $this;
    }

    /**
     * Get claveProdServ
     *
     * @return \App\Models\ClaveProdServ
     */
    public function getClaveProdServ()
    {
        return $this->claveProdServ;
    }

    /**
     * Set claveUnidad
     *
     * @param \App\Models\ClaveUnidad $claveUnidad
     *
     * @return Productos
     */
    public function setClaveUnidad(\App\Models\ClaveUnidad $claveUnidad)
    {
        $this->claveUnidad = $claveUnidad;

        return $this;
    }

    /**
     * Get claveUnidad
     *
     * @return \App\Models\ClaveUnidad
     */
    public function getClaveUnidad()
    {
        return $this->claveUnidad;
    }

}
