<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckMember
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
        // Check if user auth or not
        if (Auth::check())
        {
            // if user level is not user redirect to dashboard
            if (Auth::user()->level != 'user') {
                return redirect('admin');
            }
        }

        return $next($request);
    }
}
