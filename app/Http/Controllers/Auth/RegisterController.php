<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Activations;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\MessageMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;

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

  
  protected function detailRegister(RegisterRequest $request)
  {
    $name     = $request->post("name");
    $email    = $request->post("email");
    $password = $request->post("password");
	
    $data = [
		'name'     => $name,
		'email'    => $email,
		'password' => $password
    ];

    $searchEmail = User::where('email', '=', $email)->get()->count();
    if ($searchEmail < 1) {
		return view('auth.registerDetail', $data);
    } else {
		$error = "Email has been registered!";
		return view("auth.register", ['error' => $error]);
    }
  }
  protected function successRegister(Request $request)
  {
    $name          = $request->post('name');
    $email         = $request->post('email');
    $password      = $request->post('password');
    $password_hash = Hash::make($password);

	
  $user = new User;
  
	$user->nama  	     = $name;
    $user->email 	   = $email;
    $user->password  = $password_hash;
    $user->level	   = 'user';
    $user->status    = 'unverified';
	
	if ($user->save()) {
        $kodeAktifasi    = base_convert(microtime(false), 16, 32);
        
		$activations          = new Activations;
		$activations->id      = $kodeAktifasi;
		$activations->id_akun = $user->id;
		
		if ($activations->save()) {
          try {
			$kirimAktifasi = Mail::to($email)
				->send(new MessageMail($name, $kodeAktifasi));
            if (!$kirimAktifasi) {
				return view("auth.registerSuccess");
            } else {
				return view("auth.registerSuccess");
            }
          } catch (\Exception $error) {
            dd($error);
          }
        }
      
    } else {
      return redirect("/register");
    }
  }
  public function activationAccount($activationCode)
  {
	$activations = Activations::where('id',$activationCode)->first();
	$created     = new Carbon($activations->created_at);
	$now         = Carbon::now();
	$difference  = $now->diffInHours($created);
	if ($difference > 24){
		return "The Link has Expired";
	}
	if ($activations){
		$user = User::find($activations->id_akun);
		if ($user){
			$user->status = 'verified';
			$user->save();
		}
	}
	return view("auth.activationSuccess");
  }
}
