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
    Route::get('/home/{order_by?}', 'HomeController@view_home');

    /**
     * Add modules + assignments route
     * Uses the module controller to force auth
     */
    Route::get('/add', 'ModuleController@view_add');

    /**
     * Add modules + assignments route
     * Uses the module controller to force auth
     */
    Route::get('/edit', 'ModuleController@view_edit');

    /**
     * Post route for the add module form
     */
    Route::post('/add/new_module', 'ModuleController@add_new_module')->name('addNewModule');

    /**
     * Post route for the add assignment form
     */
    Route::post('/add/new_assignment', 'ModuleController@add_new_assignment')->name('addNewAssignment');
});
