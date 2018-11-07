<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Models\Repositories\UsersRepository")
* @ORM\Table(name="users")
*/
class Users extends Auth
{

    public static function getListPermisos() {
        return [
            'TIMBRES_TRANSFERENCIA' => 'TIMBRES_TRANSFERENCIA',
            'DOCUMENTOS_POR_APROBAR' => 'DOCUMENTOS_POR_APROBAR',
            'USUARIOS' => 'USUARIOS',
            'PAGOS_REP_PENDIENTES' => 'PAGOS_REP_PENDIENTES',
            'PAGOS_REP_TODOS' => 'PAGOS_REP_TODOS',
            'REPORTE_PAGOS_CONTABILIDAD' => 'REPORTE_PAGOS_CONTABILIDAD',
            'REPORTE_PAGOS_TIMBRES' => 'REPORTE_PAGOS_TIMBRES',
            'PERIODOS_TERMINADOS' => 'PERIODOS_TERMINADOS',
            'SOLICITUD_PERIODOS' => 'SOLICITUD_PERIODOS',
            'USUARIOS_SIN_DESCARGAS' => 'USUARIOS_SIN_DESCARGAS',
            'USUARIOS_CON_DESCARGAS' => 'USUARIOS_CON_DESCARGAS',
            'PLANES_VENCIDOS' => 'PLANES_VENCIDOS',
            'FACTURAS_SOLICITADAS' => 'FACTURAS_SOLICITADAS',
            'VERIFICAR_CIEC' => 'VERIFICAR_CIEC',
        ];
    }

    /**
    * @ORM\Column(type="integer",name="timbres_disponibles",nullable=false)
    */
    private $timbresDisponibles;

    /**
    * @ORM\Column(type="string",length=5,name="plantilla",nullable=false)
    */
    private $plantilla;

    /**
    * @ORM\Column(type="string",length=5,name="api_env",nullable=false)
    */
    private $apiEnv;

    /**
    * @ORM\Column(type="integer",name="plantillasPDF",nullable=false)
    */
    private $plantillaPDF;

    /**
    * @ORM\Column(type="integer",name="admin",nullable=false)
    */
    private $admin;

    /**
    * @ORM\OneToMany(targetEntity="Productos", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $productos;

    /**
    * @ORM\OneToMany(targetEntity="Clientes", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $clientes;

    /**
    * @ORM\OneToMany(targetEntity="TimbresMovs", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $timbresMovs;

    /**
    * @ORM\OneToMany(targetEntity="TimbresMovs", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $timbresMovsTransferencia;

    /**
    * @ORM\OneToMany(targetEntity="Facturas", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $facturas;

    /**
    * @ORM\OneToMany(targetEntity="Nominas", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $nominas;

    /**
    * @ORM\OneToMany(targetEntity="Impuestos", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $impuestos;

    /**
    * @ORM\OneToMany(targetEntity="Folios", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $folios;

    /**
    * @ORM\OneToMany(targetEntity="ReportarPagos", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false, fetch="EXTRA_LAZY")
    */
    private $reportarPagos;

    /**
    * @ORM\OneToMany(targetEntity="Empleados", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false, fetch="EXTRA_LAZY")
    */
    private $empleados;

    /**
    * @ORM\OneToOne(targetEntity="UsersPerfil", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $perfil;

    /**
    * @ORM\OneToOne(targetEntity="UsersLogo", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $logo;

    /**
    * @ORM\OneToOne(targetEntity="UsersInfoFactura", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=false)
    */
    private $infoFactura;

    /**
    * @ORM\Column(type="boolean",name="completar_perfil",nullable=true)
    */
    private $completarPerfil;

    public function __construct() {
        $this->timbresDisponibles = 0;
        $this->plantilla = 2500;
        $this->apiEnv = 'TEST';
    }

    public function checkAccess($permiso) {
        if (in_array($permiso, $this->permisos)) {
            return true;
        }

        return false;
    }

    public function isComplete() {
        return $this->completarPerfil;
    }

    public function isDocumentosValidados() {
        $infoFactura = $this->getInfoFactura();

        if (empty($infoFactura)) {
            return false;
        }

        $documentos = $infoFactura->getDocumentos();
        if (count($documentos) < 2) {
            return false;
        }

        foreach ($infoFactura->getDocumentos() as $documento) {
            if (!$documento->getValidado()) {
                return false;
            }
        }

        return true;
    }

    public function getFolioByTipo($tipo) {
        foreach ($this->folios as $folio) {
            if ($folio->getTipo() === $tipo) {
                return $folio;
            }
        }

        return null;
    }

    /**
     * Set info
     *
     * @param \App\Models\UsersPerfil $perfil
     *
     * @return Users
     */
    public function setPerfil(\App\Models\UsersPerfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get info
     *
     * @return \App\Models\UsersPerfil
     */
    public function getPerfil()
    {
        return !empty($this->perfil) ? $this->perfil : new UsersPerfil($this);
    }

    /**
     * Set logo
     *
     * @param \App\Models\UsersLogo $logo
     *
     * @return Users
     */
    public function setLogo(\App\Models\UsersLogo $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \App\Models\UsersLogo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set infoFactura
     *
     * @param \App\Models\UsersInfoFactura $infoFactura
     *
     * @return Users
     */
    public function setInfoFactura(\App\Models\UsersInfoFactura $infoFactura = null)
    {
        $this->infoFactura = $infoFactura;

        return $this;
    }

    /**
     * Get infoFactura
     *
     * @return \App\Models\UsersInfoFactura
     */
    public function getInfoFactura()
    {
        return $this->infoFactura;
    }

    /**
     * Set timbresDisponibles
     *
     * @param integer $timbresDisponibles
     *
     * @return Users
     */
    public function setTimbresDisponibles($timbresDisponibles)
    {
        $this->timbresDisponibles = $timbresDisponibles;

        return $this;
    }

    /**
     * Get timbresDisponibles
     *
     * @return integer
     */
    public function getTimbresDisponibles()
    {
        return $this->timbresDisponibles;
    }

    /**
     * Add timbresMov
     *
     * @param \App\Models\TimbresMovs $timbresMov
     *
     * @return Users
     */
    public function addTimbresMov(\App\Models\TimbresMovs $timbresMov)
    {
        $this->timbresMovs[] = $timbresMov;

        return $this;
    }

    /**
     * Remove timbresMov
     *
     * @param \App\Models\TimbresMovs $timbresMov
     */
    public function removeTimbresMov(\App\Models\TimbresMovs $timbresMov)
    {
        $this->timbresMovs->removeElement($timbresMov);
    }

    /**
     * Get timbresMovs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTimbresMovs()
    {
        return $this->timbresMovs;
    }

    /**
     * Add timbresMovsTransferencium
     *
     * @param \App\Models\TimbresMovs $timbresMovsTransferencium
     *
     * @return Users
     */
    public function addTimbresMovsTransferencium(\App\Models\TimbresMovs $timbresMovsTransferencium)
    {
        $this->timbresMovsTransferencia[] = $timbresMovsTransferencium;

        return $this;
    }

    /**
     * Remove timbresMovsTransferencium
     *
     * @param \App\Models\TimbresMovs $timbresMovsTransferencium
     */
    public function removeTimbresMovsTransferencium(\App\Models\TimbresMovs $timbresMovsTransferencium)
    {
        $this->timbresMovsTransferencia->removeElement($timbresMovsTransferencium);
    }

    /**
     * Get timbresMovsTransferencia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTimbresMovsTransferencia()
    {
        return $this->timbresMovsTransferencia;
    }

    /**
     * Add producto
     *
     * @param \App\Models\Productos $producto
     *
     * @return Users
     */
    public function addProducto(\App\Models\Productos $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \App\Models\Productos $producto
     */
    public function removeProducto(\App\Models\Productos $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Add cliente
     *
     * @param \App\Models\Clientes $cliente
     *
     * @return Users
     */
    public function addCliente(\App\Models\Clientes $cliente)
    {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \App\Models\Clientes $cliente
     */
    public function removeCliente(\App\Models\Clientes $cliente)
    {
        $this->clientes->removeElement($cliente);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }

    /**
     * Add factura
     *
     * @param \App\Models\Facturas $factura
     *
     * @return Users
     */
    public function addFactura(\App\Models\Facturas $factura)
    {
        $this->facturas[] = $factura;

        return $this;
    }

    /**
     * Remove factura
     *
     * @param \App\Models\Facturas $factura
     */
    public function removeFactura(\App\Models\Facturas $factura)
    {
        $this->facturas->removeElement($factura);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->facturas;
    }

    /**
     * Set plantilla
     *
     * @param string $plantilla
     *
     * @return UsersPerfil
     */
    public function setPlantilla($plantilla)
    {
        $this->plantilla = $plantilla;

        return $this;
    }

    /**
     * Get plantilla
     *
     * @return string
     */
    public function getPlantilla()
    {
        return $this->plantilla;
    }

    /**
     * Add impuesto
     *
     * @param \App\Models\Impuestos $impuesto
     *
     * @return Users
     */
    public function addImpuesto(\App\Models\Impuestos $impuesto)
    {
        $this->impuestos[] = $impuesto;

        return $this;
    }

    /**
     * Remove impuesto
     *
     * @param \App\Models\Impuestos $impuesto
     */
    public function removeImpuesto(\App\Models\Impuestos $impuesto)
    {
        $this->impuestos->removeElement($impuesto);
    }

    /**
     * Get impuestos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImpuestos()
    {
        return $this->impuestos;
    }

    /**
     * Add folio
     *
     * @param \App\Models\Folios $folio
     *
     * @return Users
     */
    public function addFolio(\App\Models\Folios $folio)
    {
        $this->folios[] = $folio;

        return $this;
    }

    /**
     * Remove folio
     *
     * @param \App\Models\Folios $folio
     */
    public function removeFolio(\App\Models\Folios $folio)
    {
        $this->folios->removeElement($folio);
    }

    /**
     * Get folios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFolios()
    {
        return $this->folios;
    }

    /**
     * Add reportarPago
     *
     * @param \App\Models\ReportarPagos $reportarPago
     *
     * @return Users
     */
    public function addReportarPago(\App\Models\ReportarPagos $reportarPago)
    {
        $this->reportarPagos[] = $reportarPago;

        return $this;
    }

    /**
     * Remove reportarPago
     *
     * @param \App\Models\ReportarPagos $reportarPago
     */
    public function removeReportarPago(\App\Models\ReportarPagos $reportarPago)
    {
        $this->reportarPagos->removeElement($reportarPago);
    }

    /**
     * Get reportarPagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReportarPagos()
    {
        return $this->reportarPagos;
    }

    /**
     * Add empleado
     *
     * @param \App\Models\Empleados $empleado
     *
     * @return Users
     */
    public function addEmpleado(\App\Models\Empleados $empleado)
    {
        $this->empleados[] = $empleado;

        return $this;
    }

    /**
     * Remove empleado
     *
     * @param \App\Models\Empleados $empleado
     */
    public function removeEmpleado(\App\Models\Empleados $empleado)
    {
        $this->empleados->removeElement($empleado);
    }

    /**
     * Get empleados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpleados()
    {
        return $this->empleados;
    }

    /**
     * Add nomina
     *
     * @param \App\Models\Nominas $nomina
     *
     * @return Users
     */
    public function addNomina(\App\Models\Nominas $nomina)
    {
        $this->nominas[] = $nomina;

        return $this;
    }

    /**
     * Remove nomina
     *
     * @param \App\Models\Nominas $nomina
     */
    public function removeNomina(\App\Models\Nominas $nomina)
    {
        $this->nominas->removeElement($nomina);
    }

    /**
     * Get nominas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNominas()
    {
        return $this->nominas;
    }

     /**
     * Set apiEnv
     *
     * @param string $apiEnv
     *
     * @return Users
     */
    public function setApiEnv($apiEnv)
    {
        $this->apiEnv = $apiEnv;

        return $this;
    }

    /**
     * Get apiEnv
     *
     * @return string
     */
    public function getApiEnv()
    {
        return $this->apiEnv;
    }
    
    /**
     * Set completarPerfil
     *
     * @param boolean $completarPerfil
     *
     * @return Users
     */
    public function setCompletarPerfil($completarPerfil)
    {
        $this->completarPerfil = $completarPerfil;

        return $this;
    }

    /**
     * Get completarPerfil
     *
     * @return boolean
     */
    public function getCompletarPerfil()
    {
        return $this->completarPerfil;
    }

    /**
     * Set plantillaPDF
     *
     * @param integer $plantillaPDF
     *
     * @return Users
     */
    public function setPlantillaPDF($plantillaPDF)
    {
        $this->plantillaPDF = $plantillaPDF;

        return $this;
    }

    /**
     * Get plantillaPDF
     *
     * @return integer
     */
    public function getPlantillaPDF()
    {
        return $this->plantillaPDF;
    }

    /**
     * Set admin
     *
     * @param integer $admin
     *
     * @return Users
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get plantillaPDF
     *
     * @return integer
     */
    public function getAdmin()
    {
        return $this->admin;
    }
}
