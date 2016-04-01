<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Assignment;
use Validator;

class AssignmentController extends Controller {

    /**
     * Assignment controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the edit assignment view
     * Pass the current assignment data so we can add it to the form (so the user can edit it)
     */
    public function view_edit_assignment($assignment_id) {
        // Get the modules for the select box
        $user = Auth::user();
        $modules = $user->modules()->orderBy('module_code', 'asc')->get();
        // Get the assignment we want to edit (for some reason Assignment::find wouldn't work here so i've had to use a work around
        // I also tried $user->modules()->assignments() but that didn't work either so I checked for the user_id manually in the if statement below
        $assignment = Assignment::where('id', $assignment_id)->first();
        // If the assignment doesn't belong to the user (or if the assignment doesn't exist)
        if($assignment != null) {
            if ($assignment->module->user_id != $user->id) {
                // Remove the assignment to force an error on the view
                $assignment = null;
            }
        }
        return view('edit_assignment', [
            'assignment' => $assignment,
            'modules' => $modules
        ]);
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

    /**
     * Edit the assignment in the database - called from the post route
     */
    public function edit_assignment(Request $request) {
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
            // Redirect to module view and pass the errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the assignment we are editing
        $assignment = Assignment::find($request['assignment_id']);
        // Edit the fields
        $assignment->module_id = $request['module_id'];
        $assignment->assignment_name = $request['assignment_name'];
        $assignment->mark_percentage = $request['assignment_percentage'];
        $assignment->deadline = $request['assignment_deadline'];
        // Update in database
        $assignment->update();

        // Redirect to add module view and pass a success message
        return redirect()->back()->with('assignment_success_message', 'The assignment has successfully been edited.');
    }
}
