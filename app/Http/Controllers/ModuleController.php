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
        return view('add', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the edit module view
     * Pass the current module data so we can add it to the form (so the user can edit it)
     */
    public function view_edit_module($module_id) {
        // Get the module we want to edit
        $module = Module::where([
            ['id', $module_id],
            ['user_id', Auth::id()]
        ])->first();
        return view('edit_module', [
            'module' => $module
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
        $module->module_code = $request['module_code'];
        $module->module_name = $request['module_name'];

        // Save to database
        $request->user()->modules()->save($module);
        // Redirect to add module view and pass a success message
        return redirect()->back()->with('module_success_message', 'The module has successfully been added.');
    }

    /**
     * Edit the module in the database - called from the post route
     */
    public function edit_module(Request $request) {
        // Create a validator
        $validator = Validator::make($request->all(), [
            'module_code' => 'required|max:20',
            'module_name' => 'required|max:50'
        ]);

        // Validate
        if($validator->fails()) {
            // Redirect to module view and pass the errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $module = Module::find($request['module_id']);
        $module->module_code = $request['module_code'];
        $module->module_name = $request['module_name'];
        $module->update();

        // Redirect to add module view and pass a success message
        return redirect()->back()->with('module_success_message', 'The module has successfully been edited.');
    }
}
