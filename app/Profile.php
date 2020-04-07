<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	public function profileImage() {
		// This function returns either the photo that the user selected, or the default image 'coming soon'.
		if (isset($this->image)) {
			return '/storage/' . ($this->image);
		} else {
			return '/photos/no-photo.jpg';
		}
	}

	// disable mass assignment by setting to empty array because we are being particular about the data we are able to pass to the model in the controller (request validation)
	protected $guarded = [];

	//  in laravel links the profile to the User object in a way like a foreign key in a database. 
    public function user() {
    	return $this->belongsTo(User::class);
    }

    // link profile to users following
    public function followers() {
    	return $this->belongsToMany(User::class);
    }
}
