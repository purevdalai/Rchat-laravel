<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function users() {
        return $this->belongsToMany('App\User')
            ->withPivot('admin');
    }

    public function messages() {
        return $this->hasMany('App\Message')->with('user');
    }
}
