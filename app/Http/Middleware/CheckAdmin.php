<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckAdmin
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
        //if user level is not admin redirect to home
        if (Auth::user()->level != 'admin') {
            return redirect('/');
        }
        
        return $next($request);
    }
}
