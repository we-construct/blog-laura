<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'commentable_id',
        'commentable_type',
    ];

    protected $entity_types = [
        'User' => \App\Models\User::class,
        'Post' => \App\Models\Post::class,
        'Image' => \App\Models\PostImage::class,
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getEntityTypeAttribute($type)
    {
        if ($type === null) {
            return null;
        }

        $type = strtolower($type);
        return Arr::get($this->entity_types, $type, $type);
    }
}
