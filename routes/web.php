<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// route for index page of the profile
// Route::get('/home', 'ProfilesController@index')->name('home');


// route to update user's profile datas
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

// Route for user's profile index view and controller
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');

// route for profile edit view. notes in the controller about passing user data to controller
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');

// route for after authtication and sends the user to view everyone's posts
Route::get('/', 'PostsController@index');

// route for showing the post of the followers the user is following
Route::get('/following', 'PostsController@indexFollowing');

// route for the post comments
route::post('/comment/{post}', 'CommentsController@store');

// Route for creating posts
Route::get('/p/create', 'PostsController@create');

// route for showing individual posts
Route::get('/p/{post}', 'PostsController@show');

// Route for inserting the data using the database model
Route::post('/p', 'PostsController@store');

// Post Route for followers axios call
Route::post('/follow/{user}', 'FollowsController@store');