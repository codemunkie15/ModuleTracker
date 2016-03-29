<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\Assignment;
use App\Http\Requests;
use Auth;
use Validator;

class ModuleController extends Controller {

    /**
     * Module controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the add modules and assignments view
     */
    public function view_add() {
        // Get the modules for the user so we can display it on the select box (when adding an assignment)
        $modules = Module::where('user_id', Auth::id())->orderBy('module_code', 'asc')->get();
        // Return the view with the data
        return view('add_modules', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the edit modules and assignments view
     */
    public function view_edit() {
        // Get the modules for the user so we can display it
        $modules = Module::where('user_id', Auth::id())->orderBy('module_code', 'asc')->get();
        $assignments = array();
        // Loop through each module, fetching the assignments for the module
        foreach($modules as $module) {
            // Add the assignments to an arry to access later
            $assignments[] = Assignment::where('module_id', $module->id)->orderBy('assignment_name', 'asc')->get();
        }
        return view('edit_modules', [
            'modules' => $modules,
            'assignments' => $assignments
        ]);
    }

    /**
     * Add a new module - called from the post route (Form)
     */
    public function add_new_module(Request $request) {
        // Create a validator
        $validator = Validator::make($request->all(), [
            'module_code' => 'required|max:20',
            'module_name' => 'required|max:50'
        ]);

        // Validate
        if($validator->fails()) {
            // Redirect to module view and pass the errors
            return redirect()->back()->withErrors($validator, 'module')->withInput();
        }

        // Create the module
        $module = new Module();
        $module->user_id = Auth::id();
        $module->module_code = $request['module_code'];
        $module->module_name = $request['module_name'];

        // Save to database
        $module->save();
        // Redirect to add module view and pass a success message
        return redirect()->back()->with('module_success_message', 'The module has successfully been added.');
    }

    /**
     * Add a new assignment - called from the post route (Form)
     */
    public function add_new_assignment(Request $request) {
        // Setup a validator (with a custom error message)
        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'assignment_name' => 'required|max:80',
            'assignment_percentage' => 'required|between:1,100|integer',
            'assignment_deadline' => 'required|date_format:d-m-Y'
        ], [
            'module_id.required' => 'You need to choose a module for the assignment.'
        ]);

        // Validate
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'assignment')->withInput();
        }

        // Create assignment
        $assignment = new Assignment();
        $assignment->module_id = $request['module_id'];
        $assignment->assignment_name = $request['assignment_name'];
        $assignment->mark_percentage = $request['assignment_percentage'];
        $assignment->deadline = $request['assignment_deadline'];

        // Save to database
        $assignment->save();
        // Redirect to add module page and pass success message
        return redirect()->back()->with('assignment_success_message', 'The assignment has successfully been added.');
    }
}
