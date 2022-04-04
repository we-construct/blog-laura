<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';

    protected $fillable = [
        'post_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function posts() {
        return $this->belongsTo(Post::class);
    }
}
