<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\Assignment;
use App\Http\Requests;
use Auth;
use Validator;

class ModuleController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function view_add() {
        $modules = Module::where('user_id', Auth::id())->orderBy('module_code', 'asc')->get();
        return view('add_modules', [
            'modules' => $modules
        ]);
    }

    public function view_edit_mod() {
        return view('edit_modules');
    }

    public function add_new_module(Request $request) {
        $validator = Validator::make($request->all(), [
            'module_code' => 'required|max:20',
            'module_name' => 'required|max:50'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'module')->withInput();
        }

        $module = new Module();
        $module->user_id = Auth::id();
        $module->module_code = $request['module_code'];
        $module->module_name = $request['module_name'];

        $module->save();
        return redirect()->back()->with('module_success_message', 'The module has successfully been added.');
    }

    public function add_new_assignment(Request $request) {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'assignment_name' => 'required|max:80',
            'assignment_percentage' => 'required|between:1,100|integer',
            'assignment_deadline' => 'required|date_format:d-m-Y'
        ], [
            'module_id.required' => 'You need to choose a module for the assignment.'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'assignment')->withInput();
        }

        $assignment = new Assignment();
        $assignment->module_id = $request['module_id'];
        $assignment->assignment_name = $request['assignment_name'];
        $assignment->mark_percentage = $request['assignment_percentage'];
        $assignment->deadline = $request['assignment_deadline'];

        $assignment->save();
        return redirect()->back()->with('assignment_success_message', 'The assignment has successfully been added.');
    }
}
