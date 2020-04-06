<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // this function creates a basic title when the user is created, by firing
    protected static function boot() {
        parent::boot(); 

        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);
        });
    }

    // in laravel inks the profile object to this User object like a foreign key - note hasOne()
    public function profile() {
        return $this->hasOne(Profile::class);
    }

    // in laravel inks the post object to this User object like a foreign key - note hasMany()
    // DESC orders the object by created_at index
    public function posts() {
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    // links profiles being folowed to users
    public function following() {
        return $this->belongsToMany(Profile::class);
    }

    public function comment() {
        return $this->hasMany(Comment::class);
    }
}
