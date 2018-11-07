<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Flash;

class TimbresDisponiblesMiddleware
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
        if ($user->getTimbresDisponibles() <= 0) {
            Flash::info('No cuentas con timbres disponibles para esta operación');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }
        return $next($request);
    }
}
