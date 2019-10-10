<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;
use App\Mail\Challenge30Mail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class Challenge30Controller extends Controller
{
  public function index()
  {
    // $path = public_path().'/assets/img/WhatsApp Image 2019-08-15 at 7.30.14 PM.jpeg';
    // unlink($path);
    $getData = DB::table("tb_post")
      ->limit(10)
      ->get();
    $userId = Auth::user() ? Auth::user()->id : "foo";
    // dd($getData);
    if (count($getData) > 0) {
      foreach ($getData as $post) {
        // $image_hash = $post->image;
        // return $image_hash;
        // if(strlen($image_hash) > 0 ){
        //   $image = Crypt::decryptString($image_hash);
        // }else{
        //   $image = Crypt::encryptString($image_hash);
        // }
        $date = strtotime($post->date);
        $date_post = date("d-m-Y", $date);
      }
    } else {
      $date_post = "";
    }
    return "";
    return view("index", ['posts' => $getData, 'date' => $date_post, 'userId' => $userId]);
  }
  public function register()
  {
    return view("register");
  }
  public function detailRegister(Request $request)
  {
    $name = $request->post("name");
    $email = $request->post("email");
    $password = $request->post("password");
    $data = [
      'name' => $name,
      'email' => $email,
      'password' => $password
    ];

    $searchEmail = DB::table("tb_akun")
      ->where('email', '=', $email)
      ->get()->count();
    if ($searchEmail < 1) {
      return view('registerDetail', ['name' => $name, 'email' => $email, 'password' => $password]);
    } else {
      $error = "Email has been registered!";
      return view("register", ['error' => $error]);
    }
  }
  public function successRegister(Request $request)
  {
    $name = $request->post('name');
    $email = $request->post('email');
    $password = $request->post('password');
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $cariAkun = DB::table("tb_akun")
      ->where("email", "=", $email)
      ->get()
      ->count();
    if ($cariAkun < 1) {
      $data = [
        'nama' => $name,
        'email' => $email,
        'password' => $password_hash,
        'level' => 1,
        'status' => 0
      ];

      $insertData = DB::table("tb_akun")
        ->insert($data);
      if ($insertData) {
        $kodeAktifasi = base_convert(microtime(false), 16, 32);
        $getDataTerakhir = DB::table("tb_akun")
          ->orderBy('id', 'desc')
          ->limit(1)
          ->get();
        foreach ($getDataTerakhir as $dataTerakhir) {
          $idAkun = $dataTerakhir->id;
        }
        $data2 = [
          'id' => $kodeAktifasi,
          'id_akun' => $idAkun
        ];

        $insertAktifasi = DB::table("tb_aktifasi")
          ->insert($data2);

        if ($insertAktifasi) {
          try {

            $kirimAktifasi = Mail::to($email)
              ->send(new Challenge30Mail($name, $kodeAktifasi));
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
  public function login()
  {
    return view('login');
  }
  public function activationAccount($activationCode)
  {
    $cariAkun = DB::table("tb_aktifasi")
      ->where('id', '=', $activationCode)
      ->get();
    if ($cariAkun) {
      foreach ($cariAkun as $dataTerakhir) {
        $idAkun = $dataTerakhir->id_akun;
      }

      $updateAccount = DB::table("tb_akun")
        ->where('id', '=', $idAkun)
        ->update(['status' => 1]);
    }
    return view("activationSuccess");
  }
  public function functionLogin(Request $request)
  {

    $email = $request->post("email");
    $password = $request->post("password");


    $cariAkun = DB::table("tb_akun")
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
  public function createPost(Request $request)
  {
    try {

      $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|max:16',
        'title' => 'required|min:10|max:32',
        'body' => 'required|min:10|max:200',
        'image' => 'mimes:jpeg,jpg,png,gif|required',
        'password' => Auth::user() ? '' : 'required'
      ]);

      if ($validator->fails()) {
        return redirect('/')
          ->withErrors($validator)
          ->withInput();
      }
    } catch (\Exception $error) {
      dd($error);
    }

    $name = $request->post("name");
    $userId = Auth::user() ? Auth::user()->id : null;
    $title = $request->post("title");
    $body = $request->post("body");
    $image = $request->image;
    $password_hash = Auth::user() ? Auth::user()->password : password_hash($request->password, PASSWORD_DEFAULT);;
    // $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dir_upload = "assets/img/";
    $image_name = $image->getClientOriginalName();
    $image_name = "img_" . round(microtime(true) * 1000) . $image->getClientOriginalName();
    $image_size = $image->getClientSize();
    $image_extension = $image->extension();
    $image_hash = Crypt::encryptString($dir_upload . $image_name);
    $date_now = date("Y-m-d");
    $time_now = date("H:i");

    $getData = DB::table("tb_post")
      ->limit(10)
      ->get();

    $ekstensi = ["jpg", "jpeg", "png", "gif"];
    if (in_array($image_extension, $ekstensi)) {
      if ($image_size <= 1048576) {
        $upload = $image->move($dir_upload, $image_name);
        if ($upload) {
          $data = [
            'name' => $name,
            'id_akun' => $userId,
            'title' => $title,
            'body' => $body,
            'image' => $image_hash,
            'password' => $password_hash,
            'date' => $date_now,
            'time' => $time_now

          ];
          $insert = DB::table("tb_post")
            ->insert($data);
          if ($insert) {
            return redirect("/");
          }
        } else {
          return response("Data gagal ditambahkan!");
        }
      } else {
        return response("Image data too large");
      }
    } else {
      return response("File not an image");
    }
  }

  public function editPost(Request $request)
  {
    $image = $request->image;
    $currentPost = DB::table("tb_post")->where("id", $request->id)->first();

    if ($request->password && Auth::user()) {
      $password_verify = Auth::user()->password;
    } else if ($request->password) {
      $password_verify = password_verify($request->password, $currentPost->password);
    } else {
      $password_verify = NULL;
    }

    $ekstensi = ["jpg", "jpeg", "png", "gif"];
    $posts = [
      "name" => $request->name,
      "title" => $request->title,
      "body" => $request->body,
      "image" => $image
    ];

    if ($password_verify) {
      try {
        $validator = Validator::make($request->all(), [
          'name' => 'required|min:3|max:16',
          'title' => 'required|min:10|max:32',
          'body' => 'required|min:10|max:200',
          //'image' => 'mimes:jpeg,jpg,png,gif|required',
          'password' => Auth::user() ? '' : 'required'
        ]);
        
        if ($validator->fails()) {
          //return "error";
          return response()->json(["errorValidate" => $validator->errors(), 200]);
          //return response()->json(["error" => "Data failed to upload"]);
          return redirect("/")->withErrors($validator)
            ->withInput();
        }
      } catch (\Exception $error) {
        return response()->json(["error" => $error->getMessage()]);
      }
      if (is_string($image)) {
        if ($request->delete_img === "on") {
          $posts["image"] = "";
          DB::table("tb_post")
            ->where('id', '=', $request->id)
            ->update($posts);
          return response()->json("success");
        }
        $posts["image"] = Crypt::encryptString($image);

        DB::table("tb_post")
          ->where('id', '=', $request->id)
          ->update($posts);

        return response()->json("success");
      } else {
        $dir_upload = "assets/img/";
        $image_name = $image->getClientOriginalName();
        $image_size = $image->getClientSize();
        $image_extension = $image->extension();

        try {
          if (in_array($image_extension, $ekstensi)) {
            if ($image_size <= 1048576) {
              $upload = $image->move($dir_upload, $image_name);
              if ($upload) {
                $posts["image"] = Crypt::encryptString($dir_upload . $image_name);
                DB::table("tb_post")
                  ->where('id', '=', $request->id)
                  ->update($posts);

                return response()->json("success");
              } else {

                return response()->json(["img_error" => "Data failed to upload"]);
              }
            } else {

              return response()->json(["img_error" => "Image data too large"]);
            }
          } else {

            return response()->json(["img_error" => "File not an image"]);
          }
        } catch (\Exception $error) {
          return response()->json($error->getMessage());
        }
      }
    } else {
      return response()->json(["error" => "Wrong input password dibawah"], 201);
    }
  }
  public function deletePost(Request $request)
  {
    $id = $request->id;
    $currentPost = DB::table("tb_post")->where("id", $id)->first();
    try {
      $path = public_path() . "/" . Crypt::decryptString($currentPost->image);
      unlink($path);
      DB::table('tb_post')->where('id', $id)->delete();
      return response()->json(["success" => "Post berhasil dihapus!"]);
    } catch (\Exception $error) {

      return response()->json(["error" => $error->getMessage()]);
    }
  }
  public function checkPassword(Request $request)
  {
    $id = $request->id;
    $currentPost = DB::table("tb_post")->where("id", $id)->first();
    if ($request->password && Auth::user()) {
      $password_verify = Auth::user()->password;
    } else if ($request->password) {
      $password_verify = password_verify($request->password, $currentPost->password);
    } else {
      $password_verify = NULL;
    }
    if (!$password_verify) {
      return response()->json(["error" => "Wrong input password dibawah!"]);
    } else {
      return response()->json("success");
    }
  }
}
