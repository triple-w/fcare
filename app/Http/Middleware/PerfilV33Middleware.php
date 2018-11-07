<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Flash;

class PerfilV33Middleware
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

        if (!empty(Auth::user()->getPerfil()) && empty(Auth::user()->getPerfil()->getNumeroRegimen33())) {
            Flash::error('Debes completar el perfil para la version 3.3');
            return redirect('/users/perfil');
        }

        return $next($request);
    }
}
