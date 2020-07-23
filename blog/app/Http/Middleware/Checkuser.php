<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
class Checkuser
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
        if(Auth::check() )
        {
             return $next($request);
        }
        else if(\Auth::guard('nhankhau')->check())
        {   

             return $next($request);
        }
        else
        {
            return redirect()->route('login');
        }


        return $next($request);
    }
}