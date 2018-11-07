<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="reportar_pago")
*/
class ReportarPagos extends DoctrineEntity {

    private $rules = [
        [
            'field' => 'cantidad',
            'rule' => 'required|numeric'
        ],
        [
            'field' => 'images',
            'rule' => 'types:png,jpg,jpeg,gif,bmp',
            'mensajes' => [
                'types' => 'Solo se permiten archivos png,jpg,jpeg,gif,bmp'
            ]
        ]
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="decimal",precision=10,scale=2,name="cantidad",nullable=false)
    */
    private $cantidad;

    /**
    * @ORM\Column(type="string",length=200,name="observaciones",nullable=true)
    */
    private $observaciones;

    /**
     * @ORM\Column(type="boolean",name="aprobado",nullable=false)
     */
    private $aprobado;

    /**
    * @ORM\Column(type="string",length=200,name="comentarios_no_aprobado",nullable=true)
    */
    private $comentariosNoAprobado;

    /**
     * @ORM\Column(type="boolean",name="revisado",nullable=false)
     */
    private $revisado;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha",nullable=false)
    */
    private $fecha;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="reportarPagos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="ReportarPagosImagenes", mappedBy="reportarPago", cascade={"persist", "remove"}, orphanRemoval=false, fetch="EXTRA_LAZY")
    */
    private $imagenes;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->imagenes = new \Doctrine\Common\Collections\ArrayCollection();

        $this->aprobado = false;
        $this->revisado = false;
        $this->fecha = \Carbon\Carbon::now();

        $this->user = $user;
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ReportarPagos
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

    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return ReportarPagos
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return boolean
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set revisado
     *
     * @param boolean $revisado
     *
     * @return ReportarPagos
     */
    public function setRevisado($revisado)
    {
        $this->revisado = $revisado;

        return $this;
    }

    /**
     * Get revisado
     *
     * @return boolean
     */
    public function getRevisado()
    {
        return $this->revisado;
    }

    /**
     * Set fecha
     *
     * @param CarbonDateTime $fecha
     *
     * @return ReportarPagos
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return ReportarPagos
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
     * Add imagene
     *
     * @param \App\Models\ReportarPagosImagenes $imagene
     *
     * @return ReportarPagos
     */
    public function addImagene(\App\Models\ReportarPagosImagenes $imagene)
    {
        $this->imagenes[] = $imagene;

        return $this;
    }

    /**
     * Remove imagene
     *
     * @param \App\Models\ReportarPagosImagenes $imagene
     */
    public function removeImagene(\App\Models\ReportarPagosImagenes $imagene)
    {
        $this->imagenes->removeElement($imagene);
    }

    /**
     * Get imagenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return ReportarPagos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set comentariosNoAprobado
     *
     * @param string $comentariosNoAprobado
     *
     * @return ReportarPagos
     */
    public function setComentariosNoAprobado($comentariosNoAprobado)
    {
        $this->comentariosNoAprobado = $comentariosNoAprobado;

        return $this;
    }

    /**
     * Get comentariosNoAprobado
     *
     * @return string
     */
    public function getComentariosNoAprobado()
    {
        return $this->comentariosNoAprobado;
    }
}
