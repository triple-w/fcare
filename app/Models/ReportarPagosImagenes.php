<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="reportar_pagos_imagenes")
*/
class ReportarPagosImagenes extends UploadableEntity {

    private $rules = [
    ];

    /**
    * @ORM\ManyToOne(targetEntity="ReportarPagos", inversedBy="imagenes")
    * @ORM\JoinColumn(name="reportar_pagos_id", referencedColumnName="id", nullable=false)
    */
    private $reportarPago;

    public function __construct(\App\Models\ReportarPagos $reportarPago = null) {
        $this->reportarPago = $reportarPago;
    }

    /**
     * Set reportarPago
     *
     * @param \App\Models\ReportarPagos $reportarPago
     *
     * @return ReportarPagosImagenes
     */
    public function setReportarPago(\App\Models\ReportarPagos $reportarPago)
    {
        $this->reportarPago = $reportarPago;

        return $this;
    }

    /**
     * Get reportarPago
     *
     * @return \App\Models\ReportarPagos
     */
    public function getReportarPago()
    {
        return $this->reportarPago;
    }
}
