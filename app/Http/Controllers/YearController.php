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
        // Check if the year mark was worked out successfully
        if($year_marks != false) {
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
                'year_class_no_zero' => $year_class_no_zero,
                'worst_id' => $year_marks['worst_id']
            ]);
        } else {
            // Return the view ready to throw an error
            return view('year', [
                'modules' => $modules
            ]);
        }
    }

    public function post_drop_module(Request $request) {
        // Get the user
        $user = $request->user();
        if($request['drop_module']) {
            // Checked so value = 1
            $user->drop_module = 1;
        } else {
            // Not checked so value = 0
            $user->drop_module = 0;
        }
        // Update
        $user->update();
        // Return redirect
        return redirect()->back()->with('success_message', 'Your settings have been updated.');
    }
}
