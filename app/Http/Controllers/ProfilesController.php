<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// for passing user data back to the view
use \App\User;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
	// note (User $user) instead of (\App\User $user)
    public function index(User $user)
    {
    	// fetches the user manually. OrFail part is to give a 404 instead of crash the app. note easier way below. kept for example purposes
    	// $user = \App\User::findOrFail($user);
    	
    	// returns to the view, the $user data as an array
        // return view('profiles/index', array(
        //	'user' => $user,
        // ));

        // variable needed for the follow button's status. passes boolian for if the user's profile is being followed by the authenticated user
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
            

        // better way below to pass user info to view. note compact()
        return view('profiles/index', compact('user', 'follows'));
    }

    public function edit(User $user) {
    	//Note the namespace before the $user. Laravel makes it easy to pass user info so long as the route name variable {var} matches the variable above

    	// below authorizes against the policy ProfilePolicy.php and returns 403 not authorized if the requesting user is logged out or as another user
    	$this->authorize('update', $user->profile);

    	// note below you can use a . instead of a / for dirs
    	return view('profiles.edit', compact('user'));
    }

    public function update(User $user) {
    	// function will validate the data passed into it then update the database through the model
    	
    	// below authorizes against the policy ProfilePolicy.php and returns 403 not authorized if the requesting user is logged out or as another user
    	$this->authorize('update', $user->profile);

    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required',
    		'url' => '',
    		'image' => ''
    	]);

    	if (request('image')) {
    			// this function uploads the image only if the user has uploaded a new image
   			$imagePath = request('image')->store('profile','public');
    		// resize the image into a square then save it
	        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
	        $image->save();

	    	// As an added layer of protection, this only allows the authenticated user to update the data, though without the auth()->, it still updates through the model. note. array_merge makes image as the path, not the giant array full of data AKA the $data array has an image but the 2nd array overrides that data

	    	$data = array_merge(
	    		$data,
	    		['image' => $imagePath]
	    	);
    	}

    	// dd($data);
    	auth()->user()->profile()->update($data);

    	return redirect("/profile/{$user->id}");
    }
}

