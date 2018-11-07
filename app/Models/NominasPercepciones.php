<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="nominas_percepciones")
*/
class NominasPercepciones extends DoctrineEntity {

    private $rules = [
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=15,name="codigo",nullable=false)
    */
    private $codigo;

    /**
    * @ORM\Column(type="string",length=15,name="clave",nullable=false)
    */
    private $clave;

    /**
    * @ORM\Column(type="string",length=90,name="concepto",nullable=false)
    */
    private $concepto;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="importe_gravado",nullable=false)
    */
    private $importeGravado;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="importe_excento",nullable=false)
    */
    private $importeExcento;

    /**
    * @ORM\ManyToOne(targetEntity="Nominas", inversedBy="persepciones")
    * @ORM\JoinColumn(name="nominas_id", referencedColumnName="id", nullable=false)
    */
    private $nomina;

    public function __construct(\App\Models\Nominas $nomina = null) {
        $this->nomina = $nomina;
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return NominasPercepciones
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return NominasPercepciones
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
     * Set concepto
     *
     * @param string $concepto
     *
     * @return NominasPercepciones
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set importeGravado
     *
     * @param string $importeGravado
     *
     * @return NominasPercepciones
     */
    public function setImporteGravado($importeGravado)
    {
        $this->importeGravado = $importeGravado;

        return $this;
    }

    /**
     * Get importeGravado
     *
     * @return string
     */
    public function getImporteGravado()
    {
        return $this->importeGravado;
    }

    /**
     * Set importeExcento
     *
     * @param string $importeExcento
     *
     * @return NominasPercepciones
     */
    public function setImporteExcento($importeExcento)
    {
        $this->importeExcento = $importeExcento;

        return $this;
    }

    /**
     * Get importeExcento
     *
     * @return string
     */
    public function getImporteExcento()
    {
        return $this->importeExcento;
    }

    /**
     * Set nomina
     *
     * @param \App\Models\Nominas $nomina
     *
     * @return NominasPercepciones
     */
    public function setNomina(\App\Models\Nominas $nomina)
    {
        $this->nomina = $nomina;

        return $this;
    }

    /**
     * Get nomina
     *
     * @return \App\Models\Nominas
     */
    public function getNomina()
    {
        return $this->nomina;
    }
}
