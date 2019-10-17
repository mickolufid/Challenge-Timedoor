<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }
  
  protected function functionLogin(Request $request)
  {
	$request->validate([
		'email'    => ['required', 'string', 'email', 'max:255'],
		'password' => ['required', 'string']
	]);

    $email   	 = $request->post("email");
    $password	 = $request->post("password");
	  $akun 		 = User::where("email", $email)->first();
	if (!$akun) {
		return redirect('/login')->with('error', 'Akun Tidak Terdaftar!');
    } else {
		if ($akun->status == 0) {
			return redirect('/login')->with('error', 'Akun Belum Diverifikasi!');
		} else {
			$credentials = $request->only('email', 'password');
			if (Auth::attempt($credentials)) {
				return redirect()->intended('/');
			} else {
				return redirect('/login')->with('error', 'Error Email Or Password');
			}
        }
     }
    
  }
}
