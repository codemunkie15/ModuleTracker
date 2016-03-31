<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function assignments() {
        return $this->hasMany('App\Assignment');
    }
}
