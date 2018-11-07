<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Flash;

use App\Models\Users;

class AddPeriodoCiecMiddleware
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
        if (empty($user->getPerfil()) || empty($user->getPerfil()->getCiec())) {
            Flash::danger('Usuario no cuenta con ciec configurado');
            return redirect()->action('Users\AccountsController@getPeriodos', [ 'id' => $id ]);
        }

        return $next($request);
    }
}
