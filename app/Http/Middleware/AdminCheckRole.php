<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Roleuser;

class AdminCheckRole
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
            if(request()->user()->hasRole("admin"))
            {
                return $next($request);
            }
            else{
                $request->session()->flush();
                return redirect('/');
            }
        }
        else{
            return redirect()->guest('login');
        }
    }
}
