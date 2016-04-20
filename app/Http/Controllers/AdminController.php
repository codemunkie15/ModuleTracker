<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class AdminController extends Controller {

    /**
     * Module controller constructor
     * Forces authentication so you have to be logged in
     * Also uses admin middleware to check if the user is an admin
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function view_users() {
        // Get all the users
        $users = User::get();
        return view('admin.user_list', [
            'users' => $users
        ]);
    }
}
