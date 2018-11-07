<?php

namespace App\Http\Middleware;

use App\Models\Folios;

use Closure;
use Auth;
use Flash;

class FoliosDiffMiddleware
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

        if (empty(Folios::getDiffFolios(Auth::user(), Folios::getTiposFolio()))) {
            Flash::success('Ya se tienen registrados todos los folios disponibles para este usuario');
            return redirect()->action('Users\FoliosController@getIndex');
        }

        return $next($request);
    }
}
