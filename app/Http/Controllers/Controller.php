<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get the current year overall mark weighted by the module credits
     * Used in both YearController and DegreeController
     * Returns an array of both the normal mark and one not including 0 mark modules
     */
    public function getYearMark($modules) {
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
            // Add percentage on
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
        return [
            'mark' => $weighted,
            'mark_non_zero' => $weighted_no_zero
        ];
    }
}
