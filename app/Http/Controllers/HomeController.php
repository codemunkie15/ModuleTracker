<?php

namespace App\Http\Controllers;

use App\Assignment;
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
        $modules = Module::where('user_id', Auth::id())->orderBy($order_by, 'asc')->get();
        $assignments = array();
        // Loop through each module, fetching the assignments for the module
        foreach($modules as $module) {
            // Add the assignments to an arry to access later
            $assignments[] = Assignment::where('module_id', $module->id)->orderBy('assignment_name', 'asc')->get();
        }
        // Return the view passing the data
        return view('home', [
            'modules' => $modules,
            'assignments' => $assignments,
            'order_by' => $order_by
        ]);
    }
}
