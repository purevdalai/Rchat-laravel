<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function news() {
        return $this->hasMany('App\News');
    }

    public function tasks() {
        return $this->hasMany('App\Task');
    }

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public function meetings() {
        return $this->hasMany('App\Meeting');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function rooms() {
        return $this->belongsToMany('App\Room')
            ->withPivot('admin')
            ->with('users');
    }
}
