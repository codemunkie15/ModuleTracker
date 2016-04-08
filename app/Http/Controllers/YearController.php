<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class YearController extends Controller {

    /**
     * Year grade controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function view_year_grade() {
        // Collect the modules from the database for the user
        $user = Auth::user();
        $modules = $user->modules()->orderBy('module_code', 'asc')->get();
        // Work out the averages
        $averages = $this->moduleAverages($modules);
        // Return the view passing the data
        return view('year', [
            'modules' => $modules,
            'averages' => $averages
        ]);
    }
}
