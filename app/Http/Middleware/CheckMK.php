<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckMK
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
        $active = Auth::user()->active;
        if($active == 0){
            return redirect()->route('admin.checkMK');
        }
        else{
            return $next($request);
        }
    }
}
