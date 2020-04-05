<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class FollowsController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

    public function store(User $user) {
    	// in laravel this toggle function allows the app to switch between an established user/profiles connection and unconnected 
    	return auth()->user()->following()->toggle($user->profile);
    }
}
