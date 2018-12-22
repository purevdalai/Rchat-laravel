<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function candidates() {
        return $this->belongsToMany('App\Candidate');
    }
}
