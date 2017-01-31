<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Roleuser;

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
            if(request()->user()->hasRole("seller"))
            {
                return $next($request);
            }
            else{
                $request->session()->flush();
                return redirect('/');
            }
        }

        return redirect()->guest('login');
    }
}
