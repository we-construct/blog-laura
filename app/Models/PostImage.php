<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'main',
        'image_path',
    ];

    protected $morphClass = 'Image';

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
