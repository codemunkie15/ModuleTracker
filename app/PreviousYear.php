<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousYear extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function yearText() {
        switch($this->year) {
            case 1:
                return 'First Year';
            break;
            case 2:
                return 'Second Year';
                break;
            case 3:
                return 'Third Year';
                break;
            case 4:
                return 'Year Year';
                break;
            default:
                return 'Unknown Year';
                break;
        }
    }
}
