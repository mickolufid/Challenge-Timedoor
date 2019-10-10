<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\MessageMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
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
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name'     => ['required', 'string', 'max:255'],
      'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name'     => $data['name'],
      'email'    => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  // protected function register()
  // {
  //   //return "ss";
  //   return view("auth.register");
  // }
  protected function detailRegister(Request $request)
  {
    $name     = $request->post("name");
    $email    = $request->post("email");
    $password = $request->post("password");
    $data = [
      'name'     => $name,
      'email'    => $email,
      'password' => $password
    ];

    $searchEmail = DB::table("users")
      ->where('email', '=', $email)
      ->get()->count();
    if ($searchEmail < 1) {
      return view('registerDetail', ['name' => $name, 'email' => $email, 'password' => $password]);
    } else {
      $error = "Email has been registered!";
      return view("register", ['error' => $error]);
    }
  }
  protected function successRegister(Request $request)
  {
    $name          = $request->post('name');
    $email         = $request->post('email');
    $password      = $request->post('password');
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $cariAkun = DB::table("users")
      ->where("email", "=", $email)
      ->get()
      ->count();
    if ($cariAkun < 1) {
      $data = [
        'nama'     => $name,
        'email'    => $email,
        'password' => $password_hash,
        'level'    => 1,
        'status'   => 0
      ];

      $insertData = DB::table("users")
        ->insert($data);
      if ($insertData) {
        $kodeAktifasi    = base_convert(microtime(false), 16, 32);
        $getDataTerakhir = DB::table("users")
          ->orderBy('id', 'desc')
          ->limit(1)
          ->get();
        foreach ($getDataTerakhir as $dataTerakhir) {
          $idAkun = $dataTerakhir->id;
        }
        $data2 = [
          'id'      => $kodeAktifasi,
          'id_akun' => $idAkun
        ];

        $insertAktifasi = DB::table("activations")
          ->insert($data2);

        if ($insertAktifasi) {
          try {

            $kirimAktifasi = Mail::to($email)
              ->send(new MessageMail($name, $kodeAktifasi));
            if (!$kirimAktifasi) {
              return view("registerSuccess");
            } else {
              return view("registerSuccess");
            }
          } catch (\Exception $error) {
            dd($error);
          }
        }
      }
    } else {
      return redirect("/register");
    }
  }
  public function activationAccount($activationCode)
  {
    $cariAkun = DB::table("activations")
      ->where('id', '=', $activationCode)
      ->get();
    if ($cariAkun) {
      foreach ($cariAkun as $dataTerakhir) {
        $idAkun = $dataTerakhir->id_akun;
      }

      $updateAccount = DB::table("users")
        ->where('id', '=', $idAkun)
        ->update(['status' => 1]);
    }
    return view("activationSuccess");
  }
}