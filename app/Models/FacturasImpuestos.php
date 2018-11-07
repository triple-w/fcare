<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="facturas_impuestos")
*/
class FacturasImpuestos extends DoctrineEntity {

	private $rules = [
	];

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
	* @ORM\Column(type="string",length=10,name="impuesto",nullable=false)
	*/
	private $impuesto;

	/**
	* @ORM\Column(type="string",length=20,name="tipo",nullable=false)
	*/
	private $tipo;

    /**
    * @ORM\Column(type="integer",name="tasa",nullable=true)
    */
    private $tasa;

	/**
	* @ORM\Column(type="decimal",precision=18,scale=2,name="monto",nullable=false)
	*/
	private $monto;

	/**
	* @ORM\ManyToOne(targetEntity="Facturas", inversedBy="detalles")
	* @ORM\JoinColumn(name="users_facturas_id", referencedColumnName="id", nullable=false)
	*/
	private $factura;

    public function __construct(\App\Models\Facturas $factura = null) {
        $this->factura = $factura;
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
     * Set impuesto
     *
     * @param string $impuesto
     *
     * @return UsersFacturasIva
     */
    public function setImpuesto($impuesto)
    {
        $this->impuesto = $impuesto;

        return $this;
    }

    /**
     * Get impuesto
     *
     * @return string
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UsersFacturasIva
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return UsersFacturasIva
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set factura
     *
     * @param \App\Models\Facturas $factura
     *
     * @return UsersFacturasIva
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
     * Set tasa
     *
     * @param integer $tasa
     *
     * @return FacturasImpuestos
     */
    public function setTasa($tasa)
    {
        $this->tasa = $tasa;

        return $this;
    }

    /**
     * Get tasa
     *
     * @return integer
     */
    public function getTasa()
    {
        return $this->tasa;
    }
}
