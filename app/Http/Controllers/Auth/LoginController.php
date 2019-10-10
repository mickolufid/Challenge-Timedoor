<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    $email = $request->post("email");
    $password = $request->post("password");


    $cariAkun = DB::table("users")
      ->where("email", "=", $email)
      ->get();

    foreach ($cariAkun as $data) {
      $status = $data->status;
      $password = $data->password;
    }
    if ($cariAkun->count() < 1) {
      $error = "Akun Tidak Terdaftar!";
      return view("login", ["error" => $error]);
    } else {
      if ($status < 1) {
        $error = "Akun Belum Aktifasi!";
        return view("login", ["error" => $error]);
      } else {
        $password_verify = password_verify($password, $password);
        if ($password_verify) {
          echo "login berhasil";
        }
      }
    }
  }
}
