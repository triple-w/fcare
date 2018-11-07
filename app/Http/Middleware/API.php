<?php

namespace App\Http\Middleware;

use Closure;

class API
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

        // dump($request);die;

        $user = \App\Models\UsersAPI::findOneBy([ 'username' => $request->input('username'), 'token' => $request->input('token') ]);
        if (!$user) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
