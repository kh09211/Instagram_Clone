<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use \App\Post;

class CommentsController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

	public function store(Post $post) {
		$data = request()->validate([
			'comment' => 'required'
		]);

		auth()->user()->comment()->create([
        	'post_id' => $post->id,
            'user_id' => auth()->user()->id,
            'comment' => $data['comment']
        ]);

        return back();
	}
}
