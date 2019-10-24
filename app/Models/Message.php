<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    
	use SoftDeletes;
	
    protected $fillable = [
        'name', 'title', 'body', 'password', 'image','id_account'
    ];
	
	protected $dates    = ['deleted_at'];

    

   
}
