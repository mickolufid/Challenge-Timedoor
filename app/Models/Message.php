<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Message extends Model
{
    
    protected $fillable = [
        'name', 'title', 'body', 'password', 'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function setPasswordAttribute($value)
    {
        if ($value !== null && $value !== '') {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
