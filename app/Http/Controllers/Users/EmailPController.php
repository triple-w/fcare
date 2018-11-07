<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\EmailPersonalizado;

use Flash;
use Auth;
use Validator;
use Hash;

class EmailPController extends Controller
{
	public function __construct(Request $request) {
        parent::__construct($request);
    }
    public function getIndex(){
        $EmailP = EmailPersonalizado::findBy([ 'user' => Auth::user() ]);
    	return $this->render('emails.remitente.index',[ 'Emails' => $EmailP ]);
    }

    public function getAdd(){
        return $this->render('emails.remitente.add');
    }

    public function postAdd() {
        $user = Auth::user();
        $email = new EmailPersonalizado(Auth::user());

        $email->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        $user->setCorreo_per(true);
        $user->flush();

        if ($this->request->ajax()) {
            return $this->JSONResponse();
        }

        Flash::success('Email agregado correctamente');
        return redirect()->action('Users\EmailPController@getIndex');
    }

    public function getEdit($id) {
        $EmailP = EmailPersonalizado::find($id);
        return $this->render('emails.remitente.edit',[ 'Emails' => $EmailP ]);
    }

    public function postEdit($id) {
        $EmailP = EmailPersonalizado::find($id);

        if (!$EmailP) {
            return redirect('/');
        }

        $EmailP->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        if ($this->request->ajax()) {
            return $this->JSONResponse();
        }

        Flash::success('Email editado correctamente');
        return redirect()->action('Users\EmailPController@getIndex');
    }

    public function getDelete($id){
        $EmailP = EmailPersonalizado::find($id);
        $user = Auth::user();

        if (!$EmailP) {
            return redirect('/');
        }

        $EmailP->remove();
        $user->setCorreo_per(false);
        $user->flush();

        Flash::success('Email eliminado correctamente');
        return redirect()->action('Users\EmailPController@getIndex'); 
    }
}
?>
