<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class InfoProductos extends DoctrineEntity {

	private $rules = [
        [
            'field' => 'clave',
            'rule' => 'required|max:30'
        ],
        [
            'field' => 'unidad',
            'rule' => 'required|max:30'
        ],
        [
            'field' => 'precio',
            'rule' => 'required|numeric'
        ],
        [
            'field' => 'descripcion',
            'rule' => 'required|max:90'
        ]
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
    * @ORM\Column(type="string",length=150,name="observaciones",nullable=true)
    */
    private $observaciones;

    /**
    * @ORM\Column(type="string",length=90,name="descripcion",nullable=false)
    */
    private $descripcion;

    /**
    * @ORM\Column(type="string",length=30,name="unidad",nullable=false)
    */
    private $unidad;

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="precio",nullable=false)
    */
    private $precio;

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
     * @return Productos
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
     * Set unidad
     *
     * @param integer $unidad
     *
     * @return Productos
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return integer
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return Productos
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return InfoProductos
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return InfoProductos
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
