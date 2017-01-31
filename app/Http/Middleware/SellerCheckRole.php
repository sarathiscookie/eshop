<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Userrole;

class SellerCheckRole
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
        if (Auth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if(Auth::check())
        {
            $userRole = Userrole::select('user_roles.role_id', 'roles.role')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->where('user_roles.user_id', Auth::user()->id)
                ->first();
            if($userRole->role == 'seller')
            {
                return $next($request);
            }
        }
        else{
            return redirect()->guest('login');
        }
    }
}
