<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AppRules
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

        if (Auth::user()->getMustChangePassword()) {
            return redirect()->action('Users\AccountsController@getMustChangePassword', [ 'id' => Auth::user()->getId() ]);
        }

        return $next($request);
    }
}
