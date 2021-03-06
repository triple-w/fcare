<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="timbres_movs", indexes={
*  @ORM\Index(name="IDX_TIPO", columns={"tipo"})
* })
*/
class TimbresMovs extends DoctrineEntity {

	const AGREGAR = 'AGREGAR';

	const TRANSFERENCIA = 'TRANSFERENCIA';

	const USADO = 'USADO';

	private $rules = [
	];

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
    * @ORM\Column(type="integer",name="numero_timbres",nullable=false)
    */
    private $numeroTimbres;

    /**
    * @ORM\Column(type="CarbonDateTime",name="fecha",nullable=true)
    */
    private $fecha;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="timbresMovs")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="timbresMovsTransferencia")
    * @ORM\JoinColumn(name="users_transferencia_id", referencedColumnName="id", nullable=true)
    */
    private $userTransferencia;


    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;

        $this->fecha = \Carbon\Carbon::now();
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
     * @return TimbresMovs
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
     * Set numeroTimbres
     *
     * @param integer $numeroTimbres
     *
     * @return TimbresMovs
     */
    public function setNumeroTimbres($numeroTimbres)
    {
        $this->numeroTimbres = $numeroTimbres;

        return $this;
    }

    /**
     * Get numeroTimbres
     *
     * @return integer
     */
    public function getNumeroTimbres()
    {
        return $this->numeroTimbres;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return TimbresMovs
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
     * Set userTransferencia
     *
     * @param \App\Models\Users $userTransferencia
     *
     * @return TimbresMovs
     */
    public function setUserTransferencia(\App\Models\Users $userTransferencia = null)
    {
        $this->userTransferencia = $userTransferencia;

        return $this;
    }

    /**
     * Get userTransferencia
     *
     * @return \App\Models\Users
     */
    public function getUserTransferencia()
    {
        return $this->userTransferencia;
    }

    /**
     * Set fecha
     *
     * @param CarbonDateTime $fecha
     *
     * @return TimbresMovs
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
}
