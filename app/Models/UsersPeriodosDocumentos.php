<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="\App\Models\Repositories\UsersPeriodosDocumentosRepository")
* @ORM\Table(name="users_periodos_documentos", indexes={
*   @ORM\Index(name="INDX_TIPO", columns={"tipo"}),
*   @ORM\Index(name="INDX_ESTATUS", columns={"estatus"})
* })
*/
class UsersPeriodosDocumentos extends DoctrineEntity
{

    const NUEVO = 'NUEVO';
    const PAGADO = 'PAGADO';
    const NO_PAGADO = 'NO_PAGADO';

    const EMITIDO = 'EMITIDO';
    const RECIBIDO = 'RECIBIDO';

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=15,name="tipo",nullable=false)
    */
    private $tipo;

    /**
    * @ORM\Column(type="string",length=15,name="estatus",nullable=false)
    */
    private $estatus;

    /**
    * @ORM\Column(type="boolean",name="cancelado",nullable=false)
    */
    private $cancelado;

    /**
    * @ORM\Column(type="array",name="datos",nullable=false)
    */
    private $datos;

    /**
    * @ORM\Column(type="text",name="xml",nullable=false)
    */
    private $xml;

    /**
    * @ORM\ManyToOne(targetEntity="UsersPeriodos", inversedBy="documentos")
    * @ORM\JoinColumn(name="users_periodos_id", referencedColumnName="id", nullable=false)
    */
    private $periodo;

    /**
    * @ORM\OneToMany(targetEntity="UsersPeriodosDocumentosPagos", mappedBy="documento", cascade={"persist", "remove"}, orphanRemoval=false, fetch="EXTRA_LAZY")
    */
    private $pagos;

    public function __construct(\App\Models\UsersPeriodos $periodo = null) {
        $this->periodo = $periodo;
        $this->estatus = self::NUEVO;
    }

    public function getRfcEmisor($xml = null) {
        if (empty($xml)) {
            libxml_use_internal_errors(true);
            $xml = new \DOMDocument();
            $xml->loadXml($this->getXml());
        }

        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $version = empty($comprobante->getAttribute('version')) ? $comprobante->getAttribute('Version') : $comprobante->getAttribute('version');
        $rfcEmisor = '';
        if ($version === '3.2' || $version === '3.3') {
            $emisor = $xml->getElementsByTagName('Emisor')[0];
            $rfcEmisor = empty($emisor->getAttribute('rfc')) ? $emisor->getAttribute('Rfc') : $emisor->getAttribute('rfc');
        }

        return $rfcEmisor;
    }

    public function getRfcReceptor($xml = null) {
        if (empty($xml)) {
            $xml = new \DOMDocument();
            $xml->loadXml($this->getXml());
        }

        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $version = empty($comprobante->getAttribute('version')) ? $comprobante->getAttribute('Version') : $comprobante->getAttribute('version');
        $rfcReceptor = '';
        if ($version === '3.2' || $version === '3.3') {
            $receptor = $xml->getElementsByTagName('Receptor')[0];
            $rfcReceptor = empty($receptor->getAttribute('rfc')) ? $receptor->getAttribute('Rfc') : $receptor->getAttribute('rfc');
        }

        return $rfcReceptor;
    }

    public function getTraslados($xml = null) {
        if (empty($xml)) {
            $xml = new \DOMDocument();
            $xml->loadXml($this->getXml());
        }

        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $version = empty($comprobante->getAttribute('version')) ? $comprobante->getAttribute('Version') : $comprobante->getAttribute('version');
        $traslados = [];
        if ($version === '3.2') {
            foreach ($xml->getElementsByTagName('Traslado') as $key => $traslado) {
                $traslados[$key]['importe'] = $traslado->getAttribute('importe');
                $traslados[$key]['tasa'] = $traslado->getAttribute('tasa');
                $traslados[$key]['impuesto'] = $traslado->getAttribute('impuesto');
            }
        } elseif ($version === '3.3'){
            foreach($xml->getElementsByTagName('Traslado') as $key => $traslado) {
                $traslados[$key]['importe'] = $traslado->getAttribute('Importe');
                $traslados[$key]['tasa'] = $traslado->getAttribute('TasaOCuota') * 100;
                $traslados[$key]['impuesto'] = $traslado->getAttribute('Impuesto');
            }
            array_pop($traslados);//se retira el ultimo para no tomar en cuenta el nodo traslados totales de la v3.3
        }
        return $traslados;
    }

    public function getRetenciones($xml = null) {
        if (empty($xml)) {
            $xml = new \DOMDocument();
            $xml->loadXml($this->getXml());
        }

        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $version = empty($comprobante->getAttribute('version')) ? $comprobante->getAttribute('Version') : $comprobante->getAttribute('version');
        $retenciones = [];
        if ($version === '3.2') {
            foreach ($xml->getElementsByTagName('Retencion') as $key => $retencion) {
                
                $retenciones[$key]['importe'] = $retencion->getAttribute('importe');
                $retenciones[$key]['impuesto'] = $retencion->getAttribute('impuesto');
            }
        } elseif ($version === '3.3') {
            foreach ($xml->getElementsByTagName('Retencion') as $key => $retencion) {
                $retenciones[$key]['importe'] = $retencion->getAttribute('Importe');
                $retenciones[$key]['impuesto'] = $retencion->getAttribute('Impuesto');
            }
        }
        array_pop($retenciones); //se retira el ultimo para no tomar en cuenta el nodo retenciones totales de la v3.3
        return $retenciones;
    }

    public function getSumPagos() {
        $sum = 0;
        foreach ($this->getPagos() as $pago) {
            $sum += $pago->getMonto();
        }

        return $sum;
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UsersPeriodosDocumentos
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
     * Set estatus
     *
     * @param string $estatus
     *
     * @return UsersPeriodosDocumentos
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
     * Set cancelado
     *
     * @param boolean $cancelado
     *
     * @return UsersPeriodosDocumentos
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    /**
     * Get cancelado
     *
     * @return boolean
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set periodo
     *
     * @param \App\Models\UsersPeriodos $periodo
     *
     * @return UsersPeriodosDocumentos
     */
    public function setPeriodo(\App\Models\UsersPeriodos $periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \App\Models\UsersPeriodos
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set datos
     *
     * @param array $datos
     *
     * @return UsersPeriodosDocumentos
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set xml
     *
     * @param string $xml
     *
     * @return UsersPeriodosDocumentos
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
     * Add pago
     *
     * @param \App\Models\UsersPeriodosDocumentosPagos $pago
     *
     * @return UsersPeriodosDocumentos
     */
    public function addPago(\App\Models\UsersPeriodosDocumentosPagos $pago)
    {
        $this->pagos[] = $pago;

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \App\Models\UsersPeriodosDocumentosPagos $pago
     */
    public function removePago(\App\Models\UsersPeriodosDocumentosPagos $pago)
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
