<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="clientes")
*/
class Clientes extends Info {

	private $rules = [
        [
            'field' => 'email',
            'rule' => 'email'
        ]
	];

	/**
	* @ORM\Column(type="string",length=90,name="email",nullable=true)
	*/
	private $email;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="clientes")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Clientes
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Clientes
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
