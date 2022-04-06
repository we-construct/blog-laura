<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, User::class, 'country_id', 'user_id');
    }
}
