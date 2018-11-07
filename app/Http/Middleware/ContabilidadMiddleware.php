<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\UsersPagosContabilidad;

use Auth;
use Flash;

class ContabilidadMiddleware
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
        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        if (empty($ultimoPago) || $ultimoPago->getDescargasDisponibles() <= 0) {
            Flash::error('La licencia de pago expiro');
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
