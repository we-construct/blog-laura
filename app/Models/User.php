<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
    ];

    protected $appends = ['following_ids'];

    protected $morphClass = 'User';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function followers() { /*The user is a follower*/
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'following');
    }

    public function following() { /*The user is following someone*/
        return $this->belongsToMany(User::class, 'followers', 'following', 'user_id');
    }

    public function getFollowingIdsAttribute()
    {
        return $this->following->pluck('id');
    }

    public function likes() {
        return $this->hasMany(Like::class)->withTimestamps();
    }

    public function liked_posts()
    {
        return $this->belongsToMany(
            Post::class,
            'likes',
            'user_id',
            'post_id',
            'id',
            'id',
        );
    }

    public function comment_posts()
    {
        return $this->belongsToMany(
            Post::class,
            'comments',
            'user_id',
            'post_id',
            'id',
            'id',
        )->withTimestamps();
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function users_comments() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
