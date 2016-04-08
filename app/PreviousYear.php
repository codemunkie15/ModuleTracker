<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousYear extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
}
