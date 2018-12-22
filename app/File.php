<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function message() {
        return $this->belongsTo('App\Message');
    }
}
