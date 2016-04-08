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
        // Work out the total grade weighted by the credits
        // work out the credit percentages
        $total_credits = 0;
        $total_credits_no_zero = 0;
        foreach($modules as $module) {
            $total_credits += $module->credits;
            if($averages[$module->id] > 0) {
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
                $weighted += $averages[$module->id] * $credit_percentage_40;
                if($averages[$module->id] > 0) {
                    $weighted_no_zero += $averages[$module->id] * $credit_percentage_40_no_zero;
                }
            } else {
                $weighted += $averages[$module->id] * $credit_percentage_20;
                if($averages[$module->id] > 0) {
                    $weighted_no_zero += $averages[$module->id] * $credit_percentage_20_no_zero;
                }
            }
        }
        // Return the view passing the data
        return view('year', [
            'modules' => $modules,
            'averages' => $averages,
            'year_total' => round($weighted, 2),
            'year_total_no_zero' => round($weighted_no_zero, 2)
        ]);
    }
}
