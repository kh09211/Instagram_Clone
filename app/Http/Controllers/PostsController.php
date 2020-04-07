<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
Use \App\Post;
Use \App\User;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

    
    public function index() {
        //grabs the user ids of those following
        // $users = auth()->user()->following()->pluck('profiles.user_id');
        // $posts = Post::whereIn('user_id', $users)->latest()->get();

        // The posts being sent to the page and then paginated
        $posts = Post::latest()->paginate(10);
        
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
        $image = Image::make(public_path("storage/{$imagePath}"));
        $image->orientate();
        $image->fit(1200, 900);
        $image->save();

    	auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);
    	
    	return redirect('/profile/' . auth()->user()->id);
    }

    // laravel post model binding to fetch the post
    public function show(\App\Post $post,User $user) {
        
        // variable needed for the follow button's status. passes boolian for if the user's profile is being followed by the authenticated user
        
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;

        // compct is to replace an array of data sent to the view
        return view('posts.show', compact('post', 'user', 'follows'));
    }

    public function destroy(\App\Post $post) {
        
        // function deletes the uploaded photo and then the entire post
        Storage::delete('public/' . $post->image);
        Post::destroy($post->id);

        return redirect('/profile/' . $post->user->id);
    }
}
