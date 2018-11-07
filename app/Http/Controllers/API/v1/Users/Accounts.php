<?php

namespace App\Http\Controllers\API\v1\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users;

use EntityManager;

class Accounts extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function postRegister() {

        $user = new Users();
        $user->setVerified(false);
        $user->setActive(true);
        $user->setRecovery(false);
        $user->changeHash();
        $user->setMustChangePassword(false);
        $user->setRol('ROLE_USUARIO');
        $user->save($this->request, [], [
            'flush' => true,
        ]);

        return [ 'success' => '1', 'hash' => $user->getHash() ];
    }

    public function getActivate($hash) {

        $user = Users::findOneBy([ 'hash' => $hash ]);

        $user->setVerified(true);
        $user->save([], [], [
            'flush' => true
        ]);

        return [ 'success' => '1' ];
    }

    public function postRecoveryEmail() {
        $user = Users::findOneBy([ 'email' => $this->request->input('email') ]);

        if ($user) {
            $user->changeHash();
            $user->setRecovery(true);
            $user->save([], [] ,[
                'validate' => false,
                'flush' => true
            ]);

            return [ 
                'success' => '1', 
                'msg' => 'Se ha enviado un correo de recuperación al correo especificado', 
                'data' =>  [
                    'hash' => $user->getHash(),
                ]
            ];

        }

        return [ 'success' => '2', 'msg' => 'Usuario no encontrado' ];

    }

    public function postRecovery() {
        $user = Users::findOneBy([ 'hash' => $hash ]);

        if (empty($user) || !$user->getRecovery()) {

            return [ 
                'success' => '2', 
                'msg' => '', 
            ];

        }

        $user->setRecovery(false);
        $user->changeHash();
        $user->save($this->request, [ 'password' ], [
            'validate' => false,
            'flush' => true
        ]);

        return [ 'success' => '2', 'msg' => 'Password cambiado correctamente' ];

    }

}

?>