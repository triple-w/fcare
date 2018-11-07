<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\ClaveUnidadRepository")
* @ORM\Table(name="clave_unidad")
*/
class ClaveUnidad extends DoctrineEntity {

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
    * @ORM\OneToMany(targetEntity="Productos", mappedBy="claveUnidad", cascade={"persist", "remove"}, orphanRemoval=false)
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
     * @return ClaveUnidad
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
     * @return ClaveUnidad
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add producto
     *
     * @param \App\Models\Productos $producto
     *
     * @return ClaveUnidad
     */
    public function addProducto(\App\Models\Productos $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \App\Models\Productos $producto
     */
    public function removeProducto(\App\Models\Productos $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
