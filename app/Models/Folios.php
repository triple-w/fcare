<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="folios")
*/
class Folios extends DoctrineEntity {

    const INGRESO = 'INGRESO';
    const EGRESO = 'EGRESO';
    const TRASLADO = 'TRASLADO';
    const PAGOS = 'PAGOS';

    public static function getTiposFolio() {
        return [ 
            self::INGRESO => 'Ingreso', 
            self::EGRESO => 'Egreso',
            self::TRASLADO => 'Traslado',
            self::PAGOS => 'Pagos', 
        ];
    }

    private $rules = [
        [
            'field' => 'serie',
            'rule' => 'required|max:30'
        ],
        [
            'field' => 'folio',
            'rule' => 'required|integer'
        ]
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
    * @ORM\Column(type="string",length=30,name="tipo",nullable=false)
    */
    private $tipo;

    /**
    * @ORM\Column(type="string",length=20,name="serie",nullable=false)
    */
    private $serie;

    /**
    * @ORM\Column(type="integer",name="folio",nullable=false)
    */
    private $folio;

    /**
    * @ORM\ManyToOne(targetEntity="Users", inversedBy="folios")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id", nullable=false)
    */
    private $user;

    public function __construct(\App\Models\Users $user = null) {
        $this->user = $user;
    }

    public static function getDiffFolios($user, $tiposFolio) {
        $folios = $user->getFolios();

        $arrFolios = [];
        foreach ($folios as $folio) {
            $arrFolios[$folio->getTipo()] = $folio->getSerie();
        }

        return array_diff_key($tiposFolio, $arrFolios);
    }

    public static function getSeriesByTipo($user, $tipo){
        $folios = $user->getFolios();

        $arrSeries = [];
        foreach ($folios as $folio) {
            if($folio->getTipo() == $tipo){
                $arrSeries[$folio->getId()] = $folio->getSerie(); 
            }
        }

        return $arrSeries;
    }

    public static function getFolioBySerie($user, $serie){
        $folios = $user->getFolios();

        $f = [];
        foreach ($folios as $folio) {
            if($folio->getId() == $serie){
                $f['id'] = $folio->getId();
                $f['folio'] = $folio->getFolio();
            }
        }

        return $f;
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
     * @return Folios
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
     * Set serie
     *
     * @param string $serie
     *
     * @return Folios
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set folio
     *
     * @param integer $folio
     *
     * @return Folios
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return integer
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return Folios
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
