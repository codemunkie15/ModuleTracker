<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    /**
     * Welcome route (homepage)
     * No controller necessary
     */
    Route::get('/', function () {
        return view('welcome');
    });

    /**
     * Home route (Dashboard)
     * Home controller forces auth
     * Optional parameter to sort the data
     */
    Route::get('/home/{order_by?}', 'HomeController@view_home')->name('summary');

    /**
     * Add modules + assignments route
     * Uses the module controller to force auth
     */
    Route::get('/add', 'ModuleController@view_add');

    /**
     * Edit modules route
     * Uses the module controller to force auth
     */
    Route::get('/edit/module/{id}', 'ModuleController@view_edit_module');

    /**
     * Edit assignments route
     * Uses the assignment controller to force auth
     */
    Route::get('/edit/assignment/{id}', 'AssignmentController@view_edit_assignment');

    /**
     * Delete assignment route
     * Uses the assignment controller to force auth
     */
    Route::get('/delete/assignment/{id}', 'AssignmentController@delete_assignment');

    /**
     * Post route for the add module form
     */
    Route::post('/add/new_module', 'ModuleController@add_new_module')->name('addNewModule');

    /**
     * Post route for the add assignment form
     */
    Route::post('/add/new_assignment', 'AssignmentController@add_new_assignment')->name('addNewAssignment');

    /**
     * Post route for the edit module form
     */
    Route::post('/edit/module', 'ModuleController@edit_module')->name('editModule');

    /**
     * Post route for the edit assignment form
     */
    Route::post('/edit/assignment', 'AssignmentController@edit_assignment')->name('editAssignment');
});
