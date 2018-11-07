<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Flash;

class PerfilMiddleware
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
        $perfil = $user->getPerfil();
        if (empty($perfil)) {
            Flash::error('No existe información del usuario configurada');
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
