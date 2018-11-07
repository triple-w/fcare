<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Flash;

class AdminMiddleware
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

        if (Auth::user()->getRol() !== 'ROLE_ADMIN') {
            Flash::error('No tienes permiso de entrar a esta area');
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
