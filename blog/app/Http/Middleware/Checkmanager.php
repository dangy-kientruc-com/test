<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Checkmanager
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
        if(!Auth::check())
        {
            if(Auth::guard('nhankhau')->check())
            {
                return redirect('nhan-khau/'.Auth::guard('nhankhau')->user()->hokhau_id);
            }
            return redirect()->route('truycap');
        }
        return $next($request);
    }
}
