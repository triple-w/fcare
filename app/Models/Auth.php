<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

use Hash;

/** @ORM\MappedSuperclass */
class Auth extends \App\Extensions\Doctrine\DoctrineEntity implements \Illuminate\Contracts\Auth\Authenticatable
{

    use \LaravelDoctrine\ORM\Auth\Authenticatable;

    private $rules = array(
        [
            'field' => 'email',
            'rule' => 'required|max:90|email',
            'on' => [ 'add' ]
        ],
        [
            'field' => 'username',
            'rule' => 'required|min:3|max:90|doctrine_unique:username',
            'on' => [ 'add' ]
        ],
        [
            'field' => 'password',
            'rule' => 'required|confirmed',
            'on' => [ 'change_password' , 'add', 'must_change_password'],
        ],
        [
            'field' => 'password_actual',
            'rule' => 'required|old_password',
            'on' => 'change_password',
        ],
        [   
            'field' => 'g-recaptcha-response',
            'rule' => 'required|recaptcha',
            'on' => [ 'add' ],
        ]
    );

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=90,name="email",nullable=false)
     */
    private $email;

    /**
    * @ORM\Column(type="string",length=90,name="username",nullable=false,unique=true)
    */
    private $username;

    /**
     * @ORM\Column(type="boolean",name="verified",nullable=false)
     */
    private $verified;

    /**
     * @ORM\Column(type="boolean",name="active",nullable=false)
     */
    private $active;

    /**
     * @ORM\Column(type="boolean",name="recovery",nullable=false)
     */
    private $recovery;

    /**
     * @ORM\Column(type="boolean",name="must_change_password",nullable=false)
     */
    private $mustChangePassword;

    /**
     * @ORM\Column(type="string",length=15,name="rol",nullable=false)
     */
    private $rol;

    /**
     * @ORM\Column(type="string",length=70,name="hash",nullable=false,unique=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="string",length=70,name="api_credential",nullable=false,unique=true)
     */
    private $apiCredential;

    /**
     * @ORM\Column(type="CarbonDateTime",name="last_login",nullable=true)
     */
    private $lastLogin;

    /**
    * @ORM\Column(type="boolean",name="correo_per",nullable=false)
    */
    private $correo_per;

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
     * Set email
     *
     * @param string $email
     *
     * @return Users
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
     * Set verified
     *
     * @param boolean $verified
     *
     * @return Users
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Users
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
     * Set recovery
     *
     * @param boolean $recovery
     *
     * @return Users
     */
    public function setRecovery($recovery)
    {
        $this->recovery = $recovery;

        return $this;
    }

    /**
     * Get recovery
     *
     * @return boolean
     */
    public function getRecovery()
    {
        return $this->recovery;
    }

    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return Users
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
     * Set hash
     *
     * @param string $hash
     *
     * @return Users
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    public function changeHash() {
        do {
            $hash = md5(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid()));
        } while (!empty(Users::findOneBy([ 'hash' => $hash ])));

        return $this->setHash($hash);
    }

    public function changeApiCredential() {
        do {
            $hash = md5(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid()));
        } while (!empty(Users::findOneBy([ 'apiCredential' => $hash ])));

        return $this->setApiCredential($hash);
    }

    public function getLastLogin() {
        if (!empty($this->lastLogin)) {
            return $this->lastLogin->format('Y-m-d h:i:s');
        }

        return 'Sin logeo';
    }

    public function setLastLogin() {
        $this->lastLogin = new \DateTime();
    }

    public function getNombreCompleto() {
        return sprintf("%s %s %s",
            $this->nombre,
            $this->apellidoPaterno,
            $this->apellidoMaterno
        );
    }

    public function setPassword($password)
    {
        $this->password = Hash::make($password);
    }


    /**
     * Set mustChangePassword
     *
     * @param boolean $mustChangePassword
     *
     * @return Auth
     */
    public function setMustChangePassword($mustChangePassword)
    {
        $this->mustChangePassword = $mustChangePassword;

        return $this;
    }

    /**
     * Get mustChangePassword
     *
     * @return boolean
     */
    public function getMustChangePassword()
    {
        return $this->mustChangePassword;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Users
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
     * Set apiCredential
     *
     * @param string $apiCredential
     *
     * @return Auth
     */
    public function setApiCredential($apiCredential)
    {
        $this->apiCredential = $apiCredential;

        return $this;
    }

    /**
     * Get apiCredential
     *
     * @return string
     */
    public function getApiCredential()
    {
        return $this->apiCredential;
    }

    /**
     * Set correo_per
     *
     * @param boolean $correo_per
     *
     * @return Users
     */
    public function setCorreo_per($correo_per)
    {
        $this->correo_per = $correo_per;

        return $this;
    }

    /**
    * Get correo_per
    *
    * @return boolean $correo_per
    */
    public function getCorreo_per()
    {
        return $this->correo_per;
    }
}
