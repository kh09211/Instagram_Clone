<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
Use \App\Post;

class PostsController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

    
    public function index() {
        //grabs the user ids of those following
        // $users = auth()->user()->following()->pluck('profiles.user_id');
        // $posts = Post::whereIn('user_id', $users)->latest()->get();

        $posts = Post::latest()->paginate(5);
        
        return view('posts/index', compact('posts'));
    }

    public function indexFollowing() {
        //grabs the user ids of those following

        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id', $users)->latest()->get();
        
        return view('posts/index', compact('posts'));
    }

    public function create() {
    	return view('posts/create');
    }

    public function store() {
    	$data = request()->validate([
    		'caption' => 'required',
    		'image' => ['required', 'image']
    	]);

    	$imagePath = request('image')->store('uploads','public');

        // resize the image into a square then save it
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 900);
        $image->save();

    	auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);
    	
    	return redirect('/profile/' . auth()->user()->id);
    }

    // laravel post model binding to fetch the post
    public function show(\App\Post $post) {
        
        // compct is to replace an array of data sent to the view
        return view('posts.show', compact('post'));
    }
}
