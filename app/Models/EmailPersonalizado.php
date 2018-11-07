<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="email_personalizados")
*/ 
class EmailPersonalizado extends DoctrineEntity {

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="email_pesonalizados")
    * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\Column(type="string",length=90,name="email",nullable=false)
    */
    private $email;

    /**
    * @ORM\Column(type="string",length=90,name="nombre",nullable=false)
    */
    private $nombre;

 	public function __construct(\App\Models\Users $user = null)
    {
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
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return EmailPersonalizados
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
     * Set email
     *
     * @param String $email
     *
     * @return EmailPersonalizados
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return EmailPersonalizados
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
}
?>