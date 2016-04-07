<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;
use App\Module;

class HomeController extends Controller
{
    /**
     * Home controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the summary view
     */
    public function view_home($order_by = 'module_code') {
        // Collect the modules from the database for the user
        $user = Auth::user();
        $modules = $user->modules()->orderBy($order_by, 'asc')->get();
        // Work out the module averages
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
                    $mark_count += $assignment->current_mark;
                }
                // Work out the average and store it
                $averages[$module->id] = $mark_count / count($mod_assignments);
            } else {
                // No assignments so average is 0
                $averages[$module->id] = 0;
            }
        }
        // Return the view passing the data
        return view('home', [
            'modules' => $modules,
            'averages' => $averages,
            'order_by' => $order_by
        ]);
    }
}
