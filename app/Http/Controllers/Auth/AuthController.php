<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use MultiPac;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $username = 'email_username';

    protected $redirectPath = '/dashboard';

    protected $loginPath = '/auth/login';

    protected $redirectAfterLogout = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin() {
        $this->setLayout('empty');
        return $this->render('auth.login');
    }

    protected function getCredentials(Request $request)
    {
        $credentials = $request->only($this->loginUsername(), 'password');
        $credentials['active'] = true;
        $credentials['verified'] = true;
        return $credentials;
    }

    protected function authenticated($request, $user) {
        $user->setLastLogin();
        $user->save([], [], [
            'validate' => false,
            'flush' => true
        ]);

        return redirect()->intended($this->redirectPath);
    }
}
