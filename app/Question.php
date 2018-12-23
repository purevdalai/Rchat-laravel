<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function candidates() {
        return $this->hasMany('App\Candidate');
    }
}
