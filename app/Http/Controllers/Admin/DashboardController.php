<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
		$messages = Message::withTrashed()->latest()->paginate(20);
        return view('admin.index',compact('messages'));
    }
	
	public function search(Request $request)
    {
        $messages = null;

        if ($request->has('statusOption')) {
            if ($request->statusOption === 'on') {
                $messages = Message::withoutTrashed();
            } elseif ($request->statusOption === 'delete') {
                $messages = Message::onlyTrashed();
            } else {
                $messages = Message::withTrashed();                
            }
        } else {
			$messages = new Message;
		}

        if ($request->has('title') && !empty($request->title)) {
            $messages->where('title', 'like', "%{$request->title}%");
        }

        if ($request->has('body') && !empty($request->image)) {
            $messages->where('body', 'like', "%{$request->message}%");
        }

        if ($request->has('imageOption')) {
            if ($request->imageOption === 'with') {
                $messages->where('image', '!=', '');
            } elseif ($request->imageOption === 'without') {
                $messages->where('image', '=', '');
            } else {
                $messages->where('image', 'like', '%');
            }
        }

        return view('admin.index', ['messages' => $messages->latest()->paginate(20)]);
    }

    public function delete($id)
    {
        $record = Message::find($id);

        if (!empty($record->image)) {
            File::delete('storage/images/messages/' . $record->image);

            $record->update([
                'image' => null
            ]);
        }

        $record->delete();
        
        return redirect()->back();
    }

    public function deleteMultiply(Request $request)
    {
        $request = $request->all();

        if (!empty($request['ids'])) {
            foreach ($request['ids'] as $id) {
                $record = Message::find($id);
                
                if (!empty($record->image)) {
                    File::delete('storage/images/messages/' . $record->image);
        
                    $record->update([
                        'image' => null
                    ]);
                }

                $record->delete();
            }
        }

        return redirect()->back();
    }

    public function deleteImage($id)
    {
        $record = Message::find($id);

        if (!empty($record->image)) {
            File::delete('storage/images/messages/' . $record->image);

            $record->update([
                'image' => ''
            ]);
        }

        return redirect()->back();
        
    }

    public function restore($id) 
    {
        $record = Message::onlyTrashed()->find($id);

        $record->restore();

        return redirect()->back();
    }
}
