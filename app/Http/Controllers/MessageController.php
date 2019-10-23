<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
		
		if (Auth::check()){
			if (Auth::user()->level == 'admin'){
				return redirect('/dashboard');
			}
		}
        $messages = Message::latest()->paginate(10);

        return view('message.index', compact('messages'));
    }

    public function store(Request $request)
    {

        $input = $this->validate($request, [
            'name'     => 'nullable|between:3,16',
            'title'    => 'required|between:10,32',
            'body'     => 'required|between:10,200',
            'image'    => 'mimes:jpg,jpeg,png,gif|max:1024',
            'password' => 'nullable|digits:4|numeric'
        ]);

        if ($request->hasFile('image')) {
            $name = Str::random(40) . '.' . $request->image->getClientOriginalExtension();

            $request->image->storeAs('images/messages', $name, 'public');

            $input['image'] = $name;
        } else {
            $input['image'] = '';
        }

        if (is_null($input['name'])) {
            $input['name'] = '';
        }

        $input['password'] = $input['password'] ? Hash::make($input['password']) : '';
        $input['id_akun']  = $request->user_id;

        Message::create($input);

        return redirect('/');
    }

    public function passwordVerify($request, $record)
    {
        return ['status' => true, 'errorMessage' => 'Your password is wrong', 'passwordField' => true];

        if (empty($record->password)) {
            return ['status' => false, 'errorMessage' => 'Your record is not set a password', 'passwordField' => false];
        }

        // } else {

        //     if (Hash::check($request->password, $record->password)) {
        //         return ['status' => true, 'errorMessage' => 'Password is match', 'passwordField' => false];
        //     }
        // }

        // return ['status' => false, 'errorMessage' => 'Your password is wrong', 'passwordField' => true];
    }
    
    public function delete(Request $request) 
    {
        $record = Message::find($request->id);

        if(!$record) {
            return abort(404);
        }

        $passVerified = ['status'=>true]; //$this->passwordVerify($request, $record);

        if (isset($request->user_id)) {
            $request->user_id = (int) $request->user_id;

            if ($request->user_id === $record->id_akun) {
                $passVerified['status'] = true;
            }
        }

        if (!$passVerified['status']) {
            return redirect()->back()->with([
                'record'        => $record, 
                'modal'         => 'deleteWrongModal', 
                'errorMessage'  => $passVerified['errorMessage'],
                'passwordField' => $passVerified['passwordField']
            ]);
        }
        
        return redirect()->back()->with(['record' => $record, 'modal' => 'deleteModal'])->withInput($request->all());
    }

    public function edit(Request $request) 
    {
        $record = Message::find($request->id);

        if(!$record) {
            return abort(404);
        }

        $passVerified = $this->passwordVerify($request, $record);

        if (isset($request->user_id)) {
            $request->user_id = (int) $request->user_id;

            if ($request->user_id === $record->id_akun) {
                $passVerified['status'] = true;
            }
        }

        if (!$passVerified['status']) {
            return redirect()->back()->with([
                'record'        => $record,
                'modal'         => 'editWrongModal', 
                'errorMessage'  => $passVerified['errorMessage'], 
                'passwordField' => $passVerified['passwordField']
            ]);
        }
        
        return redirect()->back()->with(['record' => $record, 'modal' => 'editModal'])->withInput($request->all());
    }

    public function destroy(Request $request, $id)
    {
        $record = Message::find($id);

        if(!$record) {
            return abort(404);
        }

        $passVerified = $this->passwordVerify($request, $record);

        if (isset($request->user_id)) {
            $request->user_id = (int) $request->user_id;

            if ($request->user_id === $record->id_akun) {
                $passVerified['status'] = true;
            }
        }

        if (!$passVerified['status']) {
            return redirect()->back()->with([
                'record'        => $record, 
                'modal'         => 'deleteWrongModal', 
                'errorMessage'  => $passVerified['errorMessage'],
                'passwordField' => $passVerified['passwordField']
            ]);
        } else {
            if (!empty($record->image)) {
                File::delete('storage/images/messages/' . $record->image);
            }

            $record->forceDelete();

            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $record = Message::find($id);

        if(!$record) {
            return abort(404);
        }

        $passVerified = $this->passwordVerify($request, $record);

        if (isset($request->user_id)) {
            $request->user_id = (int) $request->user_id;

            if ($request->user_id === $record->id_akun) {
                $passVerified['status'] = true;
            }
        }

        if (!$passVerified['status']) {
            return redirect()->back()->with([
                'record'        => $record, 
                'modal'         => 'editWrongModal', 
                'errorMessage'  => $passVerified['errorMessage'],
                'passwordField' => $passVerified['passwordField']
            ]);
        }

        $rules = [
            'editName'     => 'nullable|between:3,16',
            'editTitle'    => 'required|between:10,32',
            'editBody'     => 'required|between:10,200',
            'editImage'    => 'mimes:jpg,jpeg,png,gif|max:1024'
        ];

        $messages = [
            'editName.between'  => 'name must be :min to :max characters long',

            'editTitle.required'=> 'title must be filled in',
            'editTitle.between' => 'title must be :min to :max characters long',

            'editBody.required' => 'message must be filled in',
            'editBody.between'  => 'message must be :min to :max characters long',

            'editImage.mimes'   => 'image is only valid :values',
            'editImage.max'     => 'image is only valid 1MB or less'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            if (!empty($request->deleteImage)) {
                File::delete('storage/images/messages/' . $record->image);
                
                $record->update([
                    'image' => ''
                ]);
            } else {
                if ($request->hasFile('editImage')) {
                    File::delete('storage/images/messages/' . $record->image);

                    $name = Str::random(40) . '.' . $request->editImage->getClientOriginalExtension();

                    $request->editImage->storeAs('images/messages', $name, 'public');

                    $record->update([
                        'image' => $name
                    ]);
                }
            }

            if (is_null($request->editName)) {
                $request->editName = '';
            }

            $record->update([
                'name'    => $request->editName,
                'title'   => $request->editTitle,
                'body'    => $request->editBody
            ]);

            return redirect()->back();
        }

        return redirect()->back()
                        ->with(['modal' => 'editModal', 'record.id' => $record->id, 'record.image' => $record->image])
                        ->withErrors($validator)
                        ->withInput($request->all());
    }
}
