<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPagosContabilidad;
use App\Models\UsersPagosTimbres;

use Excel;
use PDF;
use MultiPac;

use Flash;

class ReportesAdminController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin');
        parent::__construct($request);
    }

    public function getPagosContabilidad() {
        $pagos = UsersPagosContabilidad::findAll();
        return $this->render('reportes.pagos.contabilidad', compact('pagos'));
    }

    public function getPagosTimbres() {
        $pagos = UsersPagosTimbres::findAll();
        return $this->render('reportes.pagos.timbres', compact('pagos'));
    }

    public function getPlanesVencidos() {
        $users = Users::findAll();
        return $this->render('reportes.planes_vencidos', compact('users'));
    }

    public function getFacturasPendientes() {
        $facturasContabilidad = UsersPagosContabilidad::findBy([ 'requiereFactura' => true, 'statusFactura' => 'PENDIENTE' ]);
        $facturasTimbres = UsersPagosTimbres::findBy([ 'requiereFactura' => true, 'statusFactura' => 'PENDIENTE' ]);

        return $this->render('reportes.facturas_pendientes', compact('facturasContabilidad', 'facturasTimbres'));
    }

    public function getFacturaEnviadaContabilidad($id) {
        $pago = UsersPagosContabilidad::find($id);

        $userFactura = Users::find($this->userFacturaAutomatica);
        $userToFactura = $pago->getUser();
        $preci = number_format($pago->getPrecio(), 2, '.', '');
        $iva = number_format($preci * 0.16, 2, '.', '');
        $data = [
            'Total' => $preci + $iva,
            'SubTotal' => $preci,
            'Descuento' => '0.00',
            'conceptos' => [
                [
                    'ClaveProdServ' => '84111500',
                    'ClaveUnidad' => 'E48',
                    'NoIdentificacion' => '001',
                    'Cantidad' => '1',
                    'Unidad' => 'Servicio',
                    'Descripcion' => 'Servicio de Contabilidad Electronica',
                    'ValorUnitario' => $preci,
                    'Importe' => $preci,
                    'Descuento' => '0.00',
                    'ImpuestosTrasladados' => [
                        [
                            'Base' => $preci,
                            'Impuesto' => '002',
                            'TasaOCuota' => '0.1600',
                            'Importe' => $iva,
                        ]
                    ]
                ]
            ],
            'trasladosSuma' => [
                [
                    'Impuesto' => '002',
                    'TipoFactor' => 'Tasa',
                    'TasaOCuota' => '0.1600',
                    'Importe' => $iva,
                ]
            ],
            'TotalImpuestosTrasladados' => $iva,
            'TotalImpuestosRetenidos' => '0.00',
            'email' => $userToFactura->getEmail(),
        ];
        $resFactura = MultiPac::generarFacturaWhitData($userFactura, $userToFactura, $data);

        if ($resFactura) {
            $pago->setStatusFactura('ENVIADA');
            $pago->setXml($resFactura['xml']);
            $pago->flush();

            Flash::success('Factura enviada correctamente.');
        } else {
            Flash::danger('Hubo un error al enviar la factura');
        }

        return redirect()->action('Users\ReportesAdminController@getFacturasPendientes');
    }

    public function getFacturaEnviadaTimbres($id) {
        $pago= UsersPagosTimbres::find($id);

        $userFactura = Users::find(2);
        $userToFactura = $pago->getUser();
        $preci = number_format($pago->getPrecio(), 2, '.', '');
        $iva = number_format($preci * 0.16, 2, '.', '');
        $data = [
            'Total' => $preci + $iva,
            'SubTotal' => $preci,
            'Descuento' => '0.00',
            'conceptos' => [
                [
                    'ClaveProdServ' => '84111506',
                    'ClaveUnidad' => 'E48',
                    'NoIdentificacion' => '001',
                    'Cantidad' => '1',
                    'Unidad' => 'Servicio',
                    'Descripcion' => 'Servicio de timbrado en facturacion',
                    'ValorUnitario' => $preci,
                    'Importe' => $preci,
                    'Descuento' => '0.00',
                    'ImpuestosTrasladados' => [
                        [
                            'Base' => $preci,
                            'Impuesto' => '002',
                            'TasaOCuota' => '0.1600',
                            'Importe' => $iva,
                        ]
                    ]
                ]
            ],
            'trasladosSuma' => [
                [
                    'Impuesto' => '002',
                    'TipoFactor' => 'Tasa',
                    'TasaOCuota' => '0.1600',
                    'Importe' => $iva,
                ]
            ],
            'TotalImpuestosTrasladados' => $iva,
            'TotalImpuestosRetenidos' => '0.00',
            'email' => $userToFactura->getEmail(),
        ];
        $resFactura = MultiPac::generarFacturaWhitData($userFactura, $userToFactura, $data);

        if ($resFactura) {
            $pago->setStatusFactura('ENVIADA');
            $pago->flush();

            Flash::success('Factura enviada correctamente.');
        } else {
            Flash::danger('Hubo un error al enviar la factura');
        }

        return redirect()->action('Users\ReportesAdminController@getFacturasPendientes');
    }
}
