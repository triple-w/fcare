<?php

namespace App\Models;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use EntityManager;
use Uploadable;

/** 
* @ORM\MappedSuperclass
* @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=false, callback="callback")
*/
class UploadableEntity extends \App\Extensions\Doctrine\DoctrineEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="_path", type="string", length=250, nullable=false)
     * @Gedmo\UploadableFilePath
     */
    protected $path;

    /**
     * @ORM\Column(name="_name", type="string", length=90, nullable=false)
     * Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @ORM\Column(name="_mime_type", type="string", length=50, nullable=false)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @ORM\Column(name="_size", type="decimal", nullable=false)
     * @Gedmo\UploadableFileSize
     */
    private $size;


    public function setEntityFile($path, $file) {
        Uploadable::setDefaultPath($path);
        Uploadable::addEntityFileInfo($this, $file);
    }

    public function callback(array $info) {
        $this->name = $info['fileName'];
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
     * Set path
     *
     * @param string $path
     *
     * @return UploadableEntity
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return UploadableEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return UploadableEntity
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return UploadableEntity
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }
}
