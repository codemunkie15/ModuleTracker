<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Http\Requests;
use Auth;
use App\Module;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_home($order_by = 'module_code') {
        $modules = Module::where('user_id', Auth::id())->orderBy($order_by, 'asc')->get();
        $assignments = array();
        foreach($modules as $module) {
            $assignments[] = Assignment::where('module_id', $module->id)->orderBy('assignment_name', 'asc')->get();
        }
        return view('home', [
            'modules' => $modules,
            'assignments' => $assignments,
            'order_by' => $order_by
        ]);
    }
}
