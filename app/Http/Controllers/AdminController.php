<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;

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

    public function banUser($user_id) {
        // Get the user
        $user = User::find($user_id);
        // If they are banned
        if($user->isBanned()) {
            // Un ban them
            $user->banned = 0;
            $user->update();
            $message = 'User was successfully un-banned.';
        } else {
            // Ban them
            $user->banned = 1;
            $user->update();
            $message = 'User was successfully banned.';
        }
        return redirect()->back()->with('success_message', $message);
    }

    public function makeAdmin($user_id) {
        // Get the user
        $user = User::find($user_id);
        // If they are an admin
        if($user->isAdmin()) {
            // Revoke admin
            $user->admin = 0;
            $user->update();
            $message = 'User was successfully revoked of admin rights.';
            // If we revoked our own rights
            if($user->id == Auth::user()->id) {
                // Redirect home so we don't get stuck in a redirect loop
                return redirect()->route('summary');
            }
        } else {
            // Give them admin
            $user->admin = 1;
            $user->update();
            $message = 'User was successfully given admin rights.';
        }
        return redirect()->back()->with('success_message', $message);
    }
}
