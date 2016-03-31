<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function module() {
        return $this->belongsTo('App\Module');
    }
}
