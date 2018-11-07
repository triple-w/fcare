<?php

namespace app\Models;

/**
 * UsersInfoFacturaDocumentos
 */
class UsersInfoFacturaDocumentos
{
    /**
     * @var string
     */
    private $tipo;

    /**
     * @var boolean
     */
    private $revisado;

    /**
     * @var string
     */
    private $numeroCertificado;

    /**
     * @var boolean
     */
    private $validado;

    /**
     * @var string
     */
    private $path;

    /**
     * @var \App\Models\UsersInfoFactura
     */
    private $facturaInfo;


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
     * Set path
     *
     * @param string $path
     *
     * @return UsersInfoFacturaDocumentos
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
     * Set facturaInfo
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
    public function getFacturaInfo()
    {
        return $this->facturaInfo;
    }
}

