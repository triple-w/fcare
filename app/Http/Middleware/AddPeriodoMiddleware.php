<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Flash;

use App\Models\Users;
use App\Models\UsersPagosContabilidad;

class AddPeriodoMiddleware
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
        $id = $request->route()->parameters()['one'];
        $user = Users::find($id);
        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        if (!empty($ultimoPago)) {
            if ($ultimoPago->getDescargasDisponibles() <= 0) {
                Flash::danger('Usuario no cuenta con descargas disponibles');
                return redirect()->action('Users\AccountsController@getPeriodos', [ 'id' => $id ]);
            }
        }

        return $next($request);
    }
}
