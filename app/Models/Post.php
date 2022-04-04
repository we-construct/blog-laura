<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function liked_users()
    {
        return $this->belongsToMany(
            User::class,
            'likes',
            'post_id',
            'user_id',
            'id',
            'id',
        )->withTimestamps();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function comment_users()
    {
        return $this->belongsToMany(
            User::class,
            'comments',
            'post_id',
            'user_id',
            'id',
            'id',
        )->withTimestamps();
    }
}
