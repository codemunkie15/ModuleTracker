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

    // Index route when user isn't logged in
    Route::get('/', function () {
        return view('welcome');
    });

    // Home route with option ordering parameter
    Route::get('/home/{order_by?}', 'HomeController@view_home')->name('summary');

    // Add data route
    Route::get('/add', 'ModuleController@view_add');

    // Edit data routes
    Route::get('/edit/module/{id}', 'ModuleController@view_edit_module');
    Route::get('/edit/assignment/{id}', 'AssignmentController@view_edit_assignment');

    // Delete data routes
    Route::get('/delete/module/{id}', 'ModuleController@delete_module');
    Route::get('/delete/assignment/{id}', 'AssignmentController@delete_assignment');

    // Year grade route
    Route::get('/year', 'YearController@view_year_grade');
    Route::post('/year/drop', 'YearController@post_drop_module')->name('post.drop_module');

    // Degree class route
    Route::get('/degree', 'DegreeController@view_classification');

    // Add data post routes (for forms)
    Route::post('/add/new_module', 'ModuleController@add_new_module')->name('addNewModule');
    Route::post('/add/new_assignment', 'AssignmentController@add_new_assignment')->name('addNewAssignment');

    // Edit data post routes (for forms)
    Route::post('/edit/module', 'ModuleController@edit_module')->name('editModule');
    Route::post('/edit/assignment', 'AssignmentController@edit_assignment')->name('editAssignment');

    // Degree classification post routes
    Route::post('/degree/calculate_class', 'DegreeController@calculate_classification')->name('calcClass');
    Route::post('/degree/add_previous_year', 'DegreeController@add_previous_year')->name('addPreviousYear');

    // Admin routes
    Route::get('/admin/users', 'AdminController@view_users');
    Route::get('/admin/ban/{user_id}', 'AdminController@banUser');
    Route::get('/admin/make/{user_id}', 'AdminController@makeAdmin');
});
