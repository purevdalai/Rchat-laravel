<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function files() {
        return $this->hasMany('App\File');
    }

    public function room() {
        return $this->belongsTo('App\Room');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
