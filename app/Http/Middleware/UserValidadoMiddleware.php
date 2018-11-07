<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Flash;

class UserValidadoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (empty($user->getPerfil())) {
            Flash::info('Debes de completar la información para poder facturar');
            return redirect()->action('Users\AccountsController@getPerfil');
        }

        if (!$user->isDocumentosValidados()) {
            Flash::info('Deben de estar validados los documentos corectamente');
            return redirect()->action('Users\AccountsController@getDatos');
        }

        return $next($request);
    }
}
