<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPagosContabilidad;
use App\Models\UsersPeriodos;
use App\Models\UsersPeriodosTerminados;
use App\Models\UsersPeriodosDocumentos;
use App\Models\UsersPeriodosDocumentosPagos;

use Blacktrue\Scraping\DownloadXML;
use App\Extensions\SATScraper\SATScraperCaptcha;
use Carbon\Carbon;
use App\Extensions\LibDescargaCfdi\DescargaMasivaCfdi;

use GuzzleHttp\Cookie\SessionCookieJar;

use Flash;
use Auth;

class PeriodosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin', [ 'only' => [
            'getAdd',
            'postAdd',
        ]]);
        $this->middleware('add.periodo', [ 'only' => [
            'getAdd',
            'postAdd',
        ]]);
        $this->middleware('add.periodo.ciec', [ 'only' => [
            'getAdd',
            'postAdd',
        ]]);
        $this->middleware('pagos.contabilidad', [ 'only' => [
            'getTerminar',
            'postTerminar',
            'postDocumentoPagado',
            'getDocumentoNoPagado',
            'getEdit',
            'getUpdatePeriodo',
        ]]);
        parent::__construct($request);
    }

    public function getIndex() {
        $periodos = Auth::user()->getPeriodos();
        return $this->render('users.periodos.index', [ 'periodos' => $periodos ]);
    }

    public function getTerminar() {
        return $this->render('users.periodos.terminar');
    }

    public function postTerminar() {
        $periodoTerminado = new UsersPeriodosTerminados(Auth::user());

        $periodoTerminado->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        $this->sendEmail($this->email, $this->nameEmail, 'Se termino un periodo', 'emails.accounts.periodo_terminado');
        Flash::success('Registro agregado correctamente');
        return redirect()->action('Users\PeriodosController@getIndex');
    }

    public function getAdd($id) {
        $descarga = new DescargaMasivaCfdi();
        $imagen = $descarga->ObtenerCaptcha();
        $session = $descarga->obtenerSesion();
        $this->request->session()->put('sesion_sat', $session);
        return $this->render('users.periodos.add', compact('user', 'imagen'));
    }

    public function postAdd($id) {
        $month = $this->request->input('mes');
        $year = $this->request->input('anio');
        $fecha = new Carbon("{$year}-{$month}-01");
        $fechaInicial = new Carbon($fecha->startOfMonth()->toDateString());
        $fechaFinal = new Carbon($fecha->endOfMonth()->toDateString());
        $anioInicial = $fechaInicial->year;
        $mesInicial = $fechaInicial->month;
        $diaInicial = $fechaInicial->day;
        $anioFinal = $fechaFinal->year;
        $mesFinal = $fechaFinal->month;
        $diaFinal = $fechaFinal->day;

        $user = Users::find($id);
        $perfil = $user->getPerfil();
        $ciec = $perfil->getCiec();

        $satScraper = new SATScraperCaptcha([
            'rfc' => $perfil->getRfc(),
            'ciec' => $ciec,
            'tipoDescarga' => 'recibidos',
            'cancelados' => false,
            'loginUrl' => 'https://cfdiau.sat.gob.mx/nidp/wsfed/ep?id=SATUPCFDiCon&sid=0&option=credential&sid=0',
            'captcha' => $this->request->input("captcha"),
            'session' => $this->request->session()->get('sesion_sat'),
        ]);
        $satScraper->downloadPeriod($anioInicial, $mesInicial, $diaInicial, $anioFinal, $mesFinal, $diaFinal);
        $recibidos = $satScraper->getData();

        $periodo = new UsersPeriodos($user);
        (new DownloadXML)
            ->setSatScraper($satScraper)
            ->setConcurrency(50)
            ->download(function($contentXml, $name) use ($recibidos, $periodo) {
                $xml = $contentXml->getContents();
                $key = str_replace('.xml', '', $name);

                $documento = new UsersPeriodosDocumentos($periodo);
                $documento->setTipo(UsersPeriodosDocumentos::RECIBIDO);
                $documento->setCancelado(false);
                $documento->setDatos($recibidos[$key]);
                $documento->setXml($xml);

                $periodo->addDocumento($documento);
            });

        $satScraper->setTipoDescarga('emitidos');
        $satScraper->downloadPeriod($anioInicial, $mesInicial, $diaInicial, $anioFinal, $mesFinal, $diaFinal);
        $emitidos = $satScraper->getData();

        (new DownloadXML)
            ->setSatScraper($satScraper)
            ->setConcurrency(50)
            ->download(function($contentXml, $name) use ($emitidos, $periodo) {
                $xml = $contentXml->getContents();
                $key = str_replace('.xml', '', $name);

                $documento = new UsersPeriodosDocumentos($periodo);
                $documento->setTipo(UsersPeriodosDocumentos::EMITIDO);
                $documento->setCancelado(false);
                $documento->setDatos($emitidos[$key]);
                $documento->setXml($xml);

                $periodo->addDocumento($documento);
            });

        $periodo->setFechaInicial($fechaInicial);
        $periodo->setFechaFinal($fechaFinal);
        $periodo->save($this->request, [], [
            'validate' => true,
            'flush' => false,
        ]);
        $periodo->persist();

        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        $ultimoPago->setDescargasDisponibles($ultimoPago->getDescargasDisponibles() - 1);
        $ultimoPago->flush();

        Flash::success('Periodo descargado correctamente');
        return redirect()->action('Users\AccountsController@getPeriodos', [ 'id' => $id ]);
    }

    public function getEdit($id, $tipo = "EMITIDO") {
        $periodo = UsersPeriodos::find($id);

        if (!$periodo) {
            return redirect('/');
        }

        $emitidos = UsersPeriodosDocumentos::getEmitidos($periodo);
        $recibidos = UsersPeriodosDocumentos::getRecibidos($periodo);

        $emitidosAnteriores = UsersPeriodosDocumentos::getEmitidosAnteriores($periodo);
        $recibidosAnteriores = UsersPeriodosDocumentos::getRecibidosAnteriores($periodo);

        $this->setLayout('default_nocontent');
        return $this->render('users.periodos.edit', [ 'periodo' => $periodo, 'emitidos' => $emitidos, 'recibidos' => $recibidos, 'emitidosAnteriores' => $emitidosAnteriores, 'recibidosAnteriores' => $recibidosAnteriores, 'tipo' => $tipo ]);
    }

    public function postDocumentoPagado() {
        $documento = UsersPeriodosDocumentos::find($this->request->input('documento-id'));
        $tipo = $documento->getTipo();
        $periodo = $documento->getPeriodo();

        $fechaPago = Carbon::createFromDate($periodo->getAnio(), $periodo->getMes(), 1);
        $pago = new UsersPeriodosDocumentosPagos($documento);
        $pago->save($this->request, [], [
            'validate' => true,
            'flush' => false,
        ]);
        $pago->setFechaPago($fechaPago);
        $pago->persist();

        $sumPagos = $this->request->input('monto');
        foreach ($documento->getPagos() as $pago) {
            $sumPagos += $pago->getMonto();
        }
        $valor = str_replace(',', '', substr($documento->getDatos()['total'], 1));
        if (bccomp($sumPagos, $valor, 2) === 1 || bccomp($sumPagos, $valor, 2) === 0) {
            $documento->setEstatus(UsersPeriodosDocumentos::PAGADO);
        }
        $documento->addPago($pago);
        $documento->flush();

        if ($periodo->getEstatus() === UsersPeriodos::NUEVO) {
            $check = true;
            foreach ($periodo->getDocumentos() as $documento) {
                if ($documento->getEstatus() === UsersPeriodosDocumentos::NUEVO) {
                    $check = false;
                }
            }

            if ($check) {
                $periodo->setEstatus(UsersPeriodos::COMPLETO);
                $periodo->flush();
            }
        }

        if ($this->request->ajax()) {
            return [ 'data' => 'correcto', 'pagado' => number_format($sumPagos, 2, '.', ',') ];
        }

        Flash::success('Pago realizado correctamente');
        return redirect()->action('Users\PeriodosController@getEdit', [ 'id' => $documento->getPeriodo()->getId(), 'tipo' => $tipo ]);
    }

    public function getDocumentoNoPagado($id) {
        $documento = UsersPeriodosDocumentos::find($id);

        $documento->setEstatus(UsersPeriodosDocumentos::NO_PAGADO);
        $documento->setCambioEstatus(Carbon::now());
        $documento->flush();

        $periodo = $documento->getPeriodo();
        if ($periodo->getEstatus() === UsersPeriodos::NUEVO) {
            $check = true;
            foreach ($periodo->getDocumentos() as $documento) {
                if ($documento->getEstatus() === UsersPeriodosDocumentos::NUEVO) {
                    $check = false;
                }
            }

            if ($check) {
                $periodo->setEstatus(UsersPeriodos::COMPLETO);
                $periodo->flush();
            }
        }

        Flash::success('Estatus cambiado correctamente');
        return redirect()->action('Users\PeriodosController@getEdit', [ 'id' => $documento->getPeriodo()->getId() ]);
    }

    public function getDelete($id) {
        $periodo = Periodos::find($id);

        if (!$periodo) {
            return redirect('/');
        }

        $periodo->remove();

        Flash::success('Registro eliminado correctamente');
        return redirect()->action('Periodos\PeriodosController@getIndex');
    }

    public function postChangeCiec() {
        $user = Auth::user();

        $user->getPerfil()->setCiec($this->request->input('ciec'));
        $user->getPerfil()->setVerificarCiec(true);
        $user->flush();

        Flash::success('Ciec cambiado correctamente');
        return redirect()->action('Users\PeriodosController@getIndex');
    }

    public function postUpdatePeriodo($id) {
        $periodo = UsersPeriodos::find($id);

        if (!$periodo) {
            return redirect('/');
        }

        $periodo->setIngresoSinFactura($this->request->input('ingresoSinFactura'));
        $periodo->flush();

        Flash::success('Registro actualizado correctamente');
        return redirect()->action('Users\PeriodosController@getEdit', [ 'id' => $periodo->getId() ]);
    }

    public function getDeleteDocumento($id) {
        $documento = UsersPeriodosDocumentos::find($id);

        $documento->remove();

        Flash::success('Registro eliminado correctamente');
        return redirect()->action('Users\PeriodosController@getEdit', [ 'id' => $documento->getPeriodo()->getId() ]);
    }

}