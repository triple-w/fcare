<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_info_factura")
*/
class UsersInfoFactura extends DoctrineEntity {

    private $rules = [
        [
            'field' => 'password',
            'rule' => 'required|max:90'
        ],
        [
            'field' => 'archivoCertificado',
            'rule' => 'types:cer',
            'mensajes' => [
                'types' => 'Solo se permiten archivos con extension .cer',
            ]
        ],
        [
            'field' => 'archivoLlave',
            'rule' => 'types:key',
            'mensajes' => [
                'types' => 'Solo se permiten archivos con extension .key',
            ]
        ],
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=90,name="password",nullable=false)
    */
    private $password;

    /**
    * @ORM\OneToOne(targetEntity="Users", inversedBy="infoFactura")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="UsersInfoFacturaDocumentos", mappedBy="facturaInfo", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $documentos;

    /**
     * Constructor
     */
    public function __construct(\App\Models\Users $user = null)
    {
        $this->user = $user;

        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getDocumentByType($tipo) {
        foreach ($this->getDocumentos() as $documento) {
            if ($documento->getTipo() === $tipo) {
                return $documento;
            }
        }
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
     * Set password
     *
     * @param string $password
     *
     * @return UsersInfoFactura
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersInfoFactura
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
     * Add documento
     *
     * @param \App\Models\UsersInfoFacturaDocumentos $documento
     *
     * @return UsersInfoFactura
     */
    public function addDocumento(\App\Models\UsersInfoFacturaDocumentos $documento)
    {
        $this->documentos[] = $documento;

        return $this;
    }

    /**
     * Remove documento
     *
     * @param \App\Models\UsersInfoFacturaDocumentos $documento
     */
    public function removeDocumento(\App\Models\UsersInfoFacturaDocumentos $documento)
    {
        $this->documentos->removeElement($documento);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }
}
