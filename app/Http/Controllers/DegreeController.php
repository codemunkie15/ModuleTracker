<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\PreviousYear;
use Auth;
use Response;
use App\Module;

class DegreeController extends Controller
{
    /**
     * Degree classification controller constructor
     * Forces authentication so you have to be logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the degree class view
     */
    public function view_classification() {
        // Get any previous years
        $years = Auth::user()->previousYears()->orderBy('year', 'asc')->get();
        // Get the current year mark
        $modules = Auth::user()->modules()->orderBy('module_code', 'asc')->get();
        $year_marks = $this->getYearMark($modules);
        return view('degree', [
            'years' => $years,
            'year_mark' => round($year_marks['mark'])
        ]);
    }

    /**
     * Calculate the degree classification
     */
    public function calculate_classification(Request $request) {
        // Parse the post request data (from ajax)
        parse_str($request['data'], $data);
        $validator = Validator::make($data, [
            'year.*.percentage' => 'required|integer|between:1,100',
            'year.*.mark' => 'required|integer|between:1,100',
        ], [
            'year.*.percentage.required' => 'You need to enter all the year percentages.',
            'year.*.percentage.integer' => 'Year percentages have to be an integer between 1 and 100.',
            'year.*.percentage.between' => 'Year percentages have to be an integer between 1 and 100.',
            'year.*.mark.required' => 'You need to enter all the year marks.',
            'year.*.mark.integer' => 'Year marks have to be an integer between 1 and 100.',
            'year.*.mark.between' => 'Year marks have to be an integer between 1 and 100.',
        ]);

        // If validator fails
        if($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }

        // Work out the degree class
        $mark = 0;
        // Go through every year
        foreach($data['year'] as $year) {
            // Get the percentage
            $multiplier = $year['percentage'] / 100;
            // Times it by the mark and add it on
            $mark += $multiplier * $year['mark'];
        }

        // Make a module object to use the markClass() method
        $dummy = new Module();
        $mark = round($mark, 2);

        return Response::json(array(
            'success' => true,
            'mark' => $mark,
            'class' => $dummy->markClass($mark)
        ));

    }

    /**
     * Add previous years
     */
    public function add_previous_year(Request $request) {
        // Make validator
        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'year_percentage' => 'required|integer|between:1,100',
            'year_mark' => 'required|integer|between:0,100'
        ]);

        // If validator fails
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'years')->withInput();
        }

        // Create years object
        $years = new PreviousYear();
        $years->year = $request['year'];
        $years->year_percentage = $request['year_percentage'];
        $years->mark = $request['year_mark'];
        $request->user()->PreviousYears()->save($years);

        return redirect()->back()->with('years_success_message', 'The previous year has successfully been added.');
    }
}
