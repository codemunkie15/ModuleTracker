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

    public function delete() {
        // Delete all the assignments for the module
        $this->assignments()->delete();
        // Delete the module
        return parent::delete();
    }
}
