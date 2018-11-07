<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\ClaveProdServRepository")
* @ORM\Table(name="clave_prod_serv")
*/
class ClaveProdServ extends DoctrineEntity {

    private $rules = [
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=30,name="clave",nullable=false)
    */
    private $clave;

    /**
    * @ORM\Column(type="string",length=150,name="descripcion",nullable=false)
    */
    private $descripcion;

    /**
    * @ORM\OneToMany(targetEntity="Productos", mappedBy="claveProdServ", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $productos;

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
     * Set clave
     *
     * @param string $clave
     *
     * @return ClaveProdServ
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ClaveProdServ
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

}
