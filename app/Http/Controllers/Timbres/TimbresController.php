<?php

namespace App\Http\Controllers\Timbres;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\TimbresMovs;

use Auth;
use Flash;

class TimbresController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin');
        parent::__construct($request);
    }

    public function getAdd() {
        if(Auth::user()->getId() == 1){
            return $this->render('timbres.add');
        }
        else{
            return redirect('/');
        }
    }

    public function postAdd() {
        $timbres = new TimbresMovs(Auth::user());
        $timbres->save($this->request, [], [
            'validate' => true,
            'flush' => false,
        ]);
        $timbres->setTipo(TimbresMovs::AGREGAR);

        $userTransferencia = Users::findOneBy([ 'username' => 'admin' ]);
        $userTransferencia->setTimbresDisponibles($userTransferencia->getTimbresDisponibles() + $this->request->input('numeroTimbres'));
        $userTransferencia->addTimbresMov($timbres);
        $userTransferencia->flush();

        Flash::success('Timbres Agregados correctamente');
        return redirect()->action('Timbres\TimbresController@getAdd');
    }

    public function getTransferencia() {
        return $this->render('timbres.transferencia');
    }

    public function postTransferencia() {
        $timbres = new TimbresMovs(Auth::user());
        $timbres->setTipo(TimbresMovs::TRANSFERENCIA);
        $timbres->save($this->request, [], [
            'validate' => true,
            'flush' => false,
        ]);

        $numeroTimbres = $this->request->input('numeroTimbres');

        $userRemoveTimbres = Users::findOneBy([ 'username' => 'admin' ]);
        $userRemoveTimbres->setTimbresDisponibles($userRemoveTimbres->getTimbresDisponibles() - $numeroTimbres);        
        $userRemoveTimbres->persist();

        $userTransferencia = Users::find($this->request->input('userTransferencia'));
        $userTransferencia->setTimbresDisponibles($userTransferencia->getTimbresDisponibles() + $numeroTimbres);
        $userTransferencia->addTimbresMov($timbres);
        $userTransferencia->flush();

        Flash::success('Transferencia realizada correctamente');
        return redirect()->action('Timbres\TimbresController@getTransferencia');

    }

}