<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use Auth;

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
        if (Auth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        $userID   = Auth::user()->id;
        $userRole = Role::select('role')
            ->where('user_id', $userID)
            ->first();

        if($userRole->role == 'seller')
        {
            dd('sell');//redirect to seller
        }
        else if ($userRole->role == 'buyer')
        {
            dd('buy');//redirect to buyer
        }
        else
        {
            dd('admin');//admin
        }
        /*if (! $request->user()->hasRole($role)) {
            // Redirect...
        }*/
        return $next($request);
    }
}
