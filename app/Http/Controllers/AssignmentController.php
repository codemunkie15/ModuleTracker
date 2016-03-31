<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AssignmentController extends Controller {

    /**
     * Assignment controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
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
