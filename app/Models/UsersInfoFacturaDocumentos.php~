<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users_info_factura_documentos", indexes={
*  @ORM\Index(name="IDX_TIPO", columns={"tipo"})
* })
*/
class UsersInfoFacturaDocumentos extends UploadableEntity {

    const LLAVE = 'ARCHIVO_LLAVE';
    const CERTIFICADO = 'ARCHIVO_CERTIFICADO';

    protected $allowedExtensions = [
        'key',
        'cer',
        // 'pem',
    ];

    private $rules = [
    ];

    /**
    * @ORM\Column(type="string",length=20,name="tipo",nullable=false)
    */
    private $tipo;

    /**
    * @ORM\Column(type="boolean",name="revisado",nullable=false)
    */
    private $revisado;

    /**
    * @ORM\Column(type="string",length=60,name="numero_certificado",nullable=true)
    */
    private $numeroCertificado;

    /**
    * @ORM\Column(type="boolean",name="validado",nullable=false)
    */
    private $validado;

    /**
    * @ORM\ManyToOne(targetEntity="UsersInfoFactura", inversedBy="documentos")
    * @ORM\JoinColumn(name="users_factura_info_id", referencedColumnName="id", nullable=false)
    */
    private $facturaInfo;

    public function __construct(\App\Models\UsersInfoFactura $facturaInfo = null) {
        $this->facturaInfo = $facturaInfo;

        $this->validado = false;
        $this->revisado = false;
    }

    public function callback(array $info) {

        $doctrine = \App::make('DoctrineValidation');

        if (!in_array(substr($info['fileExtension'], 1), $this->allowedExtensions)) {
            if (file_exists(public_path("uploads/users_documentos/{$info['fileName']}"))) {
                unlink(public_path("uploads/users_documentos/{$info['fileName']}"));
            }
            $doctrine->throwException([ 'message' => 'Solo se permiten archivos con extension .key, .cer' ]);
        }

        // if ($info['fileExtension'] === '.cer') {
        //     $numeroCertificado = str_replace($info['fileExtension'], '', $info['origFileName']);
        //     $split = str_split($numeroCertificado);
        //     foreach ($split as $caracter) {
        //         if (!is_numeric($caracter)) {
        //             if (file_exists(public_path("uploads/users_documentos/{$info['fileName']}"))) {
        //                 unlink(public_path("uploads/users_documentos/{$info['fileName']}"));
        //             }
        //             $doctrine->throwException([ 'message' => 'Nombre de Certificado no valido' ]);
        //         }
        //     }

        //     $path = public_path("uploads/users_documentos/{$info['fileName']}");
        //     exec("openssl x509 -inform DER -outform PEM -in {$path} -pubkey -out {$path}.pem");

        //     if (!file_exists(public_path("uploads/users_documentos/{$info['fileName']}.pem"))) {
        //         if (file_exists(public_path("uploads/users_documentos/{$info['fileName']}"))) {
        //             unlink(public_path("uploads/users_documentos/{$info['fileName']}"));
        //         }
        //         $doctrine->throwException([ 'message' => 'No se pudo crear el archivo CER pem correctamente' ]);
        //     }

        //     $this->numeroCertificado = $numeroCertificado;
        // }

        // if ($info['fileExtension'] === '.pem') {
            $numeroCertificado = str_replace($info['fileExtension'], '', $info['origFileName']);
            $this->numeroCertificado = $numeroCertificado;
        // }

        // if ($info['fileExtension'] === '.key') {
        //     $path = public_path("uploads/users_documentos/{$info['fileName']}");
        //     $request = $doctrine->getRequest();
        //     if (empty($request->input('password'))) {
        //         if (file_exists(public_path("uploads/users_documentos/{$info['fileName']}"))) {
        //             unlink(public_path("uploads/users_documentos/{$info['fileName']}"));
        //         }
        //         $doctrine->throwException([ 'message' => 'Favor de ingresar una cotraseña para el archivo KEY' ]);
        //     }
        //     $password = $request->input('password');
        //     exec("openssl pkcs8 -inform DER -in {$path} -out {$path}.pem -passin pass:{$password}");

        //     if (!file_exists(public_path("uploads/users_documentos/{$info['fileName']}.pem"))) {
        //         if (file_exists(public_path("uploads/users_documentos/{$info['fileName']}"))) {
        //             unlink(public_path("uploads/users_documentos/{$info['fileName']}"));
        //         }
        //         $doctrine->throwException([ 'message' => 'No se pudo crear el archivo KEY pem correctamente, te sugerimos verificar la contraseña del archivo, en case de que sea correcta avisar al administrador' ]);
        //     }
        // }

        parent::callback($info);
    }


    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return UsersInfoFacturaDocumentos
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
     * Set validado
     *
     * @param boolean $validado
     *
     * @return UsersInfoFacturaDocumentos
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    /**
     * Get validado
     *
     * @return boolean
     */
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * Set faturaInfo
     *
     * @param \App\Models\UsersInfoFactura $facturaInfo
     *
     * @return UsersInfoFacturaDocumentos
     */
    public function setFacturaInfo(\App\Models\UsersInfoFactura $facturaInfo)
    {
        $this->facturaInfo = $facturaInfo;

        return $this;
    }

    /**
     * Get facturaInfo
     *
     * @return \App\Models\UsersInfoFactura
     */
    public function getFaturaInfo()
    {
        return $this->facturaInfo;
    }

    /**
     * Set revisado
     *
     * @param boolean $revisado
     *
     * @return UsersInfoFacturaDocumentos
     */
    public function setRevisado($revisado)
    {
        $this->revisado = $revisado;

        return $this;
    }

    /**
     * Get revisado
     *
     * @return boolean
     */
    public function getRevisado()
    {
        return $this->revisado;
    }

    /**
     * Get facturaInfo
     *
     * @return \App\Models\UsersInfoFactura
     */
    public function getFacturaInfo()
    {
        return $this->facturaInfo;
    }

    /**
     * Set numeroCertificado
     *
     * @param string $numeroCertificado
     *
     * @return UsersInfoFacturaDocumentos
     */
    public function setNumeroCertificado($numeroCertificado)
    {
        $this->numeroCertificado = $numeroCertificado;

        return $this;
    }

    /**
     * Get numeroCertificado
     *
     * @return string
     */
    public function getNumeroCertificado()
    {
        return $this->numeroCertificado;
    }
}
