<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if($request->user() === null) {
            return response("Insufficient Permissions" , 401);
        }
        $actions = $request->user()->roles;
        $roles = isset($actions['role']) ? $actions['role'] : null;

        if($request->user()->hasRole($roles) || !$roles) {
            return $next($request);
        }
        return response("Insufficient Permissions" , 401);

    }
}
