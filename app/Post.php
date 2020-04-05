<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	// tell laravel that no need to guard anything, we handle this in the controller
	protected $guarded = [];
	
	// in laravel links this object with the User class like a foreign key in the database.
    public function user() {
    	return $this->belongsTo(User::class);
    }

}
