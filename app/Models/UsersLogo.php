<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_logo")
*/
class UsersLogo extends UploadableEntity {

	private $rules = [
	];

	/**
	* @ORM\OneToOne(targetEntity="Users", inversedBy="logo")
	* @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
	*/
	private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersLogo
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
