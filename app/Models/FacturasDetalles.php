<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="factura_detalles")
*/
class FacturasDetalles extends InfoProductos {

    private $rules = [
    ];

    /**
    * @ORM\Column(type="integer",name="cantidad",nullable=false)
    */
    private $cantidad;

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="importe",nullable=false)
    */
    private $importe;

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="nuevoPrecio",nullable=false)
    */
    private $nuevoPrecio;

    /**
    * @ORM\Column(type="decimal",precision=18,scale=2,name="iva",nullable=false)
    */
    private $iva;

    /**
     * @ORM\Column(type="boolean",name="desglosado",nullable=false)
     */
    private $desglosado;


    /**
    * @ORM\ManyToOne(targetEntity="Facturas", inversedBy="detalles")
    * @ORM\JoinColumn(name="users_facturas_id", referencedColumnName="id", nullable=false)
    */
    private $factura;

    public function __construct(\App\Models\Facturas $factura = null) {
        $this->factura = $factura;
    }


    /**
     * Set factura
     *
     * @param \App\Models\Facturas $factura
     *
     * @return UsersFacturasDetalles
     */
    public function setFactura(\App\Models\Facturas $factura)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \App\Models\UsersFacturas
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return UsersFacturasDetalles
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return UsersFacturasDetalles
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set desglosado
     *
     * @param boolean $desglosado
     *
     * @return FacturasDetalles
     */
    public function setDesglosado($desglosado)
    {
        $this->desglosado = $desglosado;

        return $this;
    }

    /**
     * Get desglosado
     *
     * @return boolean
     */
    public function getDesglosado()
    {
        return $this->desglosado;
    }
    
    /**
     * Set nuevoPrecio
     *
     * @param string $nuevoPrecio
     *
     * @return FacturasDetalles
     */
    public function setNuevoPrecio($nuevoPrecio)
    {
        $this->nuevoPrecio = $nuevoPrecio;

        return $this;
    }

    /**
     * Get nuevoPrecio
     *
     * @return string
     */
    public function getNuevoPrecio()
    {
        return $this->nuevoPrecio;
    }

    /**
     * Set iva
     *
     * @param string $iva
     *
     * @return FacturasDetalles
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return string
     */
    public function getIva()
    {
        return $this->iva;
    }
}
