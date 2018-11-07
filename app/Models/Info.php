<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Info extends DoctrineEntity {

    private $rules = [
        [
            'field' => 'rfc',
            // 'rule' => 'required|max:15',
            'rule' => 'required|max:30|regex:/^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/',
        ],
        [
            'field' => 'razonSocial',
            'rule' => 'required|max:200',
        ],
        [
            'field' => 'codigoPostal',
            'rule' => 'required|max:10',
        ],
        [
            'field' => 'email',
            'rule' => 'required|',
        ],
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=30,name="rfc",nullable=false)
    */
    private $rfc;

    /**
    * @ORM\Column(type="string",length=200,name="razon_social",nullable=false)
    */
    private $razonSocial;

    /**
    * @ORM\Column(type="string",length=90,name="calle",nullable=false)
    */
    private $calle;

    /**
    * @ORM\Column(type="string",length=10,name="no_ext",nullable=false)
    */
    private $noExt;

    /**
    * @ORM\Column(type="string",length=10,name="no_int",nullable=true)
    */
    private $noInt;

    /**
    * @ORM\Column(type="string",length=50,name="colonia",nullable=false)
    */
    private $colonia;

    /**
    * @ORM\Column(type="string",length=50,name="municipio",nullable=false)
    */
    private $municipio;

    /**
    * @ORM\Column(type="string",length=50,name="localidad",nullable=true)
    */
    private $localidad;

    /**
    * @ORM\Column(type="string",length=50,name="estado",nullable=false)
    */
    private $estado;

    /**
    * @ORM\Column(type="string",length=10,name="codigo_postal",nullable=false)
    */
    private $codigoPostal;

    /**
    * @ORM\Column(type="string",length=30,name="pais",nullable=false)
    */
    private $pais;

    /**
    * @ORM\Column(type="string",length=30,name="telefono",nullable=true)
    */
    private $telefono;

    /**
    * @ORM\Column(type="string",length=150,name="nombre_contacto",nullable=true)
    */
    private $nombreContacto;


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
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Info
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
     * @return Info
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
     * Set calle
     *
     * @param string $calle
     *
     * @return Info
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set noExt
     *
     * @param string $noExt
     *
     * @return Info
     */
    public function setNoExt($noExt)
    {
        $this->noExt = $noExt;

        return $this;
    }

    /**
     * Get noExt
     *
     * @return string
     */
    public function getNoExt()
    {
        return $this->noExt;
    }

    /**
     * Set noInt
     *
     * @param string $noInt
     *
     * @return Info
     */
    public function setNoInt($noInt)
    {
        $this->noInt = $noInt;

        return $this;
    }

    /**
     * Get noInt
     *
     * @return string
     */
    public function getNoInt()
    {
        return $this->noInt;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     *
     * @return Info
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Info
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Info
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Info
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Info
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
     * Set pais
     *
     * @param string $pais
     *
     * @return Info
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Info
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set nombreContacto
     *
     * @param string $nombreContacto
     *
     * @return Info
     */
    public function setNombreContacto($nombreContacto)
    {
        $this->nombreContacto = $nombreContacto;

        return $this;
    }

    /**
     * Get nombreContacto
     *
     * @return string
     */
    public function getNombreContacto()
    {
        return $this->nombreContacto;
    }
}
