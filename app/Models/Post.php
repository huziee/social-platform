<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'caption',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function images()
    // {
    //     return $this->hasMany(PostImage::class);
    // }
     public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    // OPTIONAL — convenience methods
    public function images()
    {
        return $this->media()->where('type', 'image');
    }

    public function videos()
    {
        return $this->media()->where('type', 'video');
    }
    public function comments()
{
    return $this->hasMany(Comment::class)->latest();
}

public function likes()
{
    return $this->hasMany(Like::class);
}

public function isLikedByAuth()
{
    return $this->likes()->where('user_id', auth()->id())->exists();
}


}
