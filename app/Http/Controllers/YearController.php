<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Module;

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
        // Get the year marks
        $year_marks = $this->getYearMark($modules);
        // Make a module object to use the markClass() method
        $dummy = new Module();
        // Get all our values
        $year_total = round($year_marks['mark'], 2);
        $year_class = $dummy->markClass($year_total);
        $year_total_no_zero = round($year_marks['mark_non_zero'], 2);
        $year_class_no_zero = $dummy->markClass($year_total_no_zero);
        // Return the view passing the data
        return view('year', [
            'modules' => $modules,
            'year_total' => $year_total,
            'year_class' => $year_class,
            'year_total_no_zero' => $year_total_no_zero,
            'year_class_no_zero' => $year_class_no_zero
        ]);
    }
}
