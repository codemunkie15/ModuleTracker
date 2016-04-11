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
        // Work out the total grade weighted by the credits
        // work out the credit percentages
        $total_credits = 0;
        $total_credits_no_zero = 0;
        foreach($modules as $module) {
            $total_credits += $module->credits;
            if($module->overallMark() > 0) {
                $total_credits_no_zero += $module->credits;
            }
        }
        $credit_percentage_20 = (20 / $total_credits);
        $credit_percentage_40 = (40 / $total_credits);
        $credit_percentage_20_no_zero = (20 / $total_credits_no_zero);
        $credit_percentage_40_no_zero = (40 / $total_credits_no_zero);
        // Work out the weighted mark for each module
        $weighted = 0;
        $weighted_no_zero = 0;
        foreach($modules as $module) {
            if($module->credits == 40) {
                $weighted += $module->overallMark() * $credit_percentage_40;
                if($module->overallMark() > 0) {
                    $weighted_no_zero += $module->overallMark() * $credit_percentage_40_no_zero;
                }
            } else {
                $weighted += $module->overallMark() * $credit_percentage_20;
                if($module->overallMark() > 0) {
                    $weighted_no_zero += $module->overallMark() * $credit_percentage_20_no_zero;
                }
            }
        }
        $dummy = new Module();
        $year_total = round($weighted, 2);
        $year_class = $dummy->markClass($year_total);
        $year_total_no_zero = round($weighted_no_zero, 2);
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
