<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="impuestos")
*/
class Impuestos extends DoctrineEntity {

	private $rules = [
		[
			'field' => 'nombre',
			'rule' => 'required|max:50'
		],
		[
			'field' => 'tasa',
			'rule' => 'required|regex:/[\d]{0,2}.[\d]{2}/',
			'mensajes' => [
				'regex' => 'Formato debe de ser 00.00',
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
    * @ORM\Column(type="string",length=50,name="nombre",nullable=false)
    */
    private $nombre;

    /**
    * @ORM\Column(type="decimal",precision=4,scale=2,name="tasa",nullable=false)
    */
    private $tasa;

    /**
    * @ORM\Column(type="string",length=30,name="tipo",nullable=false)
    */
    private $tipo;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="impuestos")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Impuestos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tasa
     *
     * @param string $tasa
     *
     * @return Impuestos
     */
    public function setTasa($tasa)
    {
        $this->tasa = $tasa;

        return $this;
    }

    /**
     * Get tasa
     *
     * @return string
     */
    public function getTasa()
    {
        return $this->tasa;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Impuestos
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Impuestos
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
}
