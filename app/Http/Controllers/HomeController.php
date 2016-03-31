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
        // Return the view passing the data
        return view('home', [
            'modules' => $modules,
            'order_by' => $order_by
        ]);
    }
}
