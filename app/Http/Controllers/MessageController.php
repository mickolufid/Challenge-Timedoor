<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class MessageController extends Controller
{
  public function index()
  {
    $getData = DB::table("messages")
      ->limit(10)
      ->get();
    $userId = Auth::user() ? Auth::user()->id : "foo";
    if (count($getData) > 0) {
      foreach ($getData as $post) {
        $date      = strtotime($post->date);
        $date_post = date("d-m-Y", $date);
      }
    } else {
      $date_post = "";
    }

    return view("message.index", ['messages' => $getData, 'date' => $date_post, 'userId' => $userId]);
  }

  public function createMessage(Request $request)
  {
    try {

      $validator = Validator::make($request->all(), [
        'name'     => 'required|min:3|max:16',
        'title'    => 'required|min:10|max:32',
        'body'     => 'required|min:10|max:200',
        'image'    => 'mimes:jpeg,jpg,png,gif|required',
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
    $password_hash = Auth::user() ? Auth::user()->password : password_hash($request->password, PASSWORD_DEFAULT);
    // $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dir_upload      = "assets/img/";
    $image_name      = $image->getClientOriginalName();
    $image_name      = "img_" . round(microtime(true) * 1000) . $image->getClientOriginalName();
    $image_size      = $image->getClientSize();
    $image_extension = $image->extension();
    $image_hash      = Crypt::encryptString($dir_upload . $image_name);
    $date_now        = date("Y-m-d");
    $time_now        = date("H:i");

    $getData = DB::table("messages")
      ->limit(10)
      ->get();

    $ekstensi = ["jpg", "jpeg", "png", "gif"];
    if (in_array($image_extension, $ekstensi)) {
      if ($image_size <= 1048576) {
        $upload = $image->move($dir_upload, $image_name);
        if ($upload) {
          $data = [
            'name'     => $name,
            'id_akun'  => $userId,
            'title'    => $title,
            'body'     => $body,
            'image'    => $image_hash,
            'password' => $password_hash,
            'date'     => $date_now,
            'time'     => $time_now

          ];
          $insert = DB::table("messages")
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

  public function editMessage(Request $request)
  {
    $image = $request->image;
    $currentPost = DB::table("messages")->where("id", $request->id)->first();

    if ($request->password && Auth::user()) {
      $password_verify = Auth::user()->password;
    } else if ($request->password) {
      $password_verify = password_verify($request->password, $currentPost->password);
    } else {
      $password_verify = NULL;
    }
    $ekstensi = ["jpg", "jpeg", "png", "gif"];
    $messages = [
      "name"  => $request->name,
      "title" => $request->title,
      "body"  => $request->body,
      "image" => $image
    ];

    if ($password_verify) {
      try {
        $validator = Validator::make($request->all(), [
          'name'     => 'required|min:3|max:16',
          'title'    => 'required|min:10|max:32',
          'body'     => 'required|min:10|max:200',
          //'image' => 'mimes:jpeg,jpg,png,gif|required',
          'password' => Auth::user() ? '' : 'required'
        ]);

        if ($validator->fails()) {
          //return "error";
          return response()->json(["errorValidate" => $validator->errors(), 200]);
          //return response()->json(["error" => "Data failed to upload"]);
          // return redirect("/")->withErrors($validator)
          //   ->withInput();
        }
      } catch (\Exception $error) {
        return response()->json(["error" => $error->getMessage()]);
      }
      if (is_string($image)) {
        if ($request->delete_img === "on") {
          $messages["image"] = "";
          DB::table("messages")
            ->where('id', '=', $request->id)
            ->update($messages);
          return response()->json("success");
        }
        $messages["image"] = Crypt::encryptString($image);

        DB::table("messages")
          ->where('id', '=', $request->id)
          ->update($messages);

        return response()->json("success");
      } else {
        $dir_upload      = "assets/img/";
        $image_name      = $image->getClientOriginalName();
        $image_size      = $image->getClientSize();
        $image_extension = $image->extension();

        try {
          if (in_array($image_extension, $ekstensi)) {
            if ($image_size <= 1048576) {
              $upload = $image->move($dir_upload, $image_name);
              if ($upload) {
                $messages["image"] = Crypt::encryptString($dir_upload . $image_name);
                DB::table("messages")
                  ->where('id', '=', $request->id)
                  ->update($messages);

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
  public function deleteMessage(Request $request)
  {
    $id          = $request->id;
    $currentPost = DB::table("messages")->where("id", $id)->first();
    try {
      $path = public_path() . "/" . Crypt::decryptString($currentPost->image);
      unlink($path);
      DB::table('messages')->where('id', $id)->delete();
      return response()->json(["success" => "Post berhasil dihapus!"]);
    } catch (\Exception $error) {

      return response()->json(["error" => $error->getMessage()]);
    }
  }
  public function checkPassword(Request $request)
  {
    $id          = $request->id;
    $currentPost = DB::table("messages")->where("id", $id)->first();
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
