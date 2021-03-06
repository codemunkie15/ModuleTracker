<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public function modules() {
        return $this->hasMany('App\Module');
    }

    public function previousYears() {
        return $this->hasMany('App\PreviousYear');
    }

    public function isAdmin() {
        if($this->admin == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isBanned() {
        if($this->banned == 1) {
            return true;
        } else {
            return false;
        }
    }
}
