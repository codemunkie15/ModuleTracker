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
        // Check if the user has any modules
        if(count($modules) > 0) {
            // Check if we need to exclude the worst marked module
            $worst_id = 0;
            if(Auth::user()->drop_module == 1) {
                // Setup a variable for the worst mark
                $worst_mark = 100;
                // Go through every module
                foreach($modules as $module) {
                    // Make sure it's not a double credit module
                    if($module->credits == 20) {
                        // Get the overall mark
                        $mark = $module->overallMark();
                        // If the mark is lower than the current lowest
                        if ($mark < $worst_mark) {
                            // Set this module as the new lowest
                            $worst_mark = $mark;
                            $worst_id = $module->id;
                        }
                    }
                }
            }
            // Work out the total grade weighted by the credits
            // work out the credit percentages
            $total_credits = 0;
            $total_credits_no_zero = 0;
            foreach ($modules as $module) {
                // Don't include the worst module
                if($module->id != $worst_id) {
                    $total_credits += $module->credits;
                    if ($module->overallMark() > 0) {
                        $total_credits_no_zero += $module->credits;
                    }
                }
            }
            $credit_percentage_20 = (20 / $total_credits);
            $credit_percentage_40 = (40 / $total_credits);
            // Make sure we're not trying to divide by 0
            if ($total_credits_no_zero > 0) {
                $credit_percentage_20_no_zero = (20 / $total_credits_no_zero);
                $credit_percentage_40_no_zero = (40 / $total_credits_no_zero);
            }
            // Work out the weighted mark for each module
            $weighted = 0;
            $weighted_no_zero = 0;
            foreach ($modules as $module) {
                // Don't include the worst module
                if($module->id != $worst_id) {
                    // Add percentage on
                    if ($module->credits == 40) {
                        $weighted += $module->overallMark() * $credit_percentage_40;
                        if ($module->overallMark() > 0) {
                            $weighted_no_zero += $module->overallMark() * $credit_percentage_40_no_zero;
                        }
                    } else {
                        $weighted += $module->overallMark() * $credit_percentage_20;
                        if ($module->overallMark() > 0) {
                            $weighted_no_zero += $module->overallMark() * $credit_percentage_20_no_zero;
                        }
                    }
                }
            }
            return [
                'mark' => $weighted,
                'mark_non_zero' => $weighted_no_zero,
                'worst_id' => $worst_id
            ];
        } else {
            return false;
        }
    }
}
