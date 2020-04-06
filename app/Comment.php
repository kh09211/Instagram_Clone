<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	// tell laravel that no need to guard anything, we handle this in the controller
	protected $guarded = [];


    Public function user() {
    	return $this->belongsTo(User::class);
    }

    Public function post() {
    	return $this->belongsTo(Post::class);
    }
}
