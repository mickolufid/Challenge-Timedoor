<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Role 
{
	public function handle($request, Closure $next, ... $roles)
	{
		if (!Auth::check()){
			return redirect('login');
		}	 
		$user = Auth::user();
		
		foreach($roles as $role) {
			if($user->level == $role){
				return $next($request);
			}
		}
		
		return redirect('/');
			
	}
}   