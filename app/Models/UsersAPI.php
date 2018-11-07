<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_api")
*/
class UsersAPI extends DoctrineEntity
{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=90,name="username",nullable=false,unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean",name="active",nullable=false)
     */
    private $active;

    /**
     * @ORM\Column(type="string",length=15,name="rol",nullable=false)
     */
    private $rol;

    /**
     * @ORM\Column(type="string",length=70,name="hash",nullable=false,unique=true)
     */
    private $token;


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
     * Set username
     *
     * @param string $username
     *
     * @return UsersAPI
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return UsersAPI
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return UsersAPI
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return UsersAPI
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function changeToken() {
        do {
            $token = md5(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid()));    
        } while (!empty(UsersAPI::findOneBy([ 'token' => $token ])));

        return $this->setToken($token);
    }
}
