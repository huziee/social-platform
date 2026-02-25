<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'comment', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    /**
     * Check if the authenticated user has liked this comment.
     */
   public function likes()
{
    // This tells Laravel to use the new 'comment_like' table 
    // instead of the 'likes' table shown in your screenshot.
    return $this->belongsToMany(User::class, 'comment_like');
}

public function isLikedByAuth()
{
    if (!auth()->check()) return false;
    
    // Checks if the user exists in the 'comment_like' table for this comment
    return $this->likes()->where('user_id', auth()->id())->exists();
}
}
