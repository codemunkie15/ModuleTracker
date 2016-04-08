<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Works out the module averages based on assignment marks and percentages
     */
    public function moduleAverages($modules) {
        // Setup an array to hold the averages
        $averages = [];
        // Go through every module
        foreach($modules as $module) {
            // Get the assignments
            $mod_assignments = $module->assignments()->get();
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
                $averages[$module->id] = round($mark_count, 2);
            } else {
                // No assignments so average is 0
                $averages[$module->id] = 0;
            }
        }
        return $averages;
    }
}
