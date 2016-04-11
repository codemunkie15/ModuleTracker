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

    public function overallMark() {
        // Get the assignments for the module
        $mod_assignments = $this->assignments()->get();
        // Check if there are any assignments for the module
        if(count($mod_assignments) > 0) {
            // Reset mark count
            $mark_count = 0;
            // Go through every assignment for the module
            foreach ($mod_assignments as $assignment) {
                // Add the mark percentage to the current count
                $mark_count += $assignment->current_mark * ($assignment->mark_percentage / 100);
            }
            // Store the average
            return round($mark_count, 2);
        } else {
            // No assignments so average is 0
            return 0;
        }
    }

    public function markClass($mark = NULL) {
        if($mark == NULL) {
            $mark = $this->overallMark();
        }
        if($mark >= 70)
            return '(1st class)';
        else if($mark >= 60)
            return '(2 : 1)';
        else if($mark >= 50)
            return '(2 : 2)';
        else if($mark >= 40)
            return '(3rd class)';
        else
            return '(Fail / Uncomplete)';
    }

    public function delete() {
        // Delete all the assignments for the module
        $this->assignments()->delete();
        // Delete the module
        return parent::delete();
    }
}
