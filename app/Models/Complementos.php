<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\ComplementosRepository")
* @ORM\Table(name="complementos")
*/
class Complementos extends DoctrineEntity {

    const TIMBRADA = 'TIMBRADA';
    const CANCELADA = 'CANCELADA';

    private $rules = [
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="complementos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha",nullable=true)
    */
    private $fecha;

    /**
    * @ORM\Column(type="string",length=10,name="codigo_postal",nullable=false)
    */
    private $codigoPostal;

    /**
    * @ORM\Column(type="string",length=30,name="rfc",nullable=false)
    */
    private $rfc;

    /**
    * @ORM\Column(type="string",length=200,name="razon_social",nullable=false)
    */
    private $razonSocial;

    /**
    * @ORM\Column(type="string",length=15,name="estatus",nullable=false)
    */
    private $estatus;

    /**
    * @ORM\Column(type="text",name="xml",nullable=false)
    */
    private $xml;

    /**
    * @ORM\Column(type="text",name="pdf",nullable=false)
    */
    private $pdf;

    /**
    * @ORM\Column(type="text",name="solicitud_timbre",nullable=false)
    */
    private $solicitudTimbre;

    /**
    * @ORM\Column(type="string",length=150,name="uuid",nullable=false)
    */
    private $uuid;

    /**
    * @ORM\Column(type="text",name="acuse",nullable=true)
    */
    private $acuse;

    /**
    * @ORM\OneToMany(targetEntity="ComplementosPagos", mappedBy="complemento", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $pagos;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;
        $this->fecha = \Carbon\Carbon::now();
    }


    public function getMontoTotal($xml = null) {
        if (empty($xml)) {
            $xml = new \DomDocument();
            $xml->loadXML($this->getXml());
        }
        $comprobante = $xml->getelementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        return empty($comprobante->getAttribute('Total')) ? $comprobante->getAttribute('total') : $comprobante->getAttribute('Total');
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Complementos
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
     * Set fecha
     *
     * @param CarbonDateTime $fecha
     *
     * @return Complementos
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return CarbonDateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Complementos
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Complementos
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return Complementos
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return Complementos
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return Complementos
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
     * Set pdf
     *
     * @param string $pdf
     *
     * @return Complementos
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set solicitudTimbre
     *
     * @param string $solicitudTimbre
     *
     * @return Complementos
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
     * Set uuid
     *
     * @param string $uuid
     *
     * @return Complementos
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set acuse
     *
     * @param string $acuse
     *
     * @return Complementos
     */
    public function setAcuse($acuse)
    {
        $this->acuse = $acuse;

        return $this;
    }

    /**
     * Get acuse
     *
     * @return string
     */
    public function getAcuse()
    {
        return $this->acuse;
    }


    /**
     * Add pago
     *
     * @param \App\Models\ComplementosPagos $pago
     *
     * @return Complementos
     */
    public function addPago(\App\Models\ComplementosPagos $pago)
    {
        $this->pagos[] = $pago;

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \App\Models\ComplementosPagos $pago
     */
    public function removePago(\App\Models\ComplementosPagos $pago)
    {
        $this->pagos->removeElement($pago);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos()
    {
        return $this->pagos;
    }

}
