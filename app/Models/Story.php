<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Story extends Model
{
    protected $fillable = ['user_id', 'media_path', 'type', 'expires_at'];

    // Auto-scope to only get active stories
    public function scopeActive($query) {
        return $query->where('expires_at', '>', Carbon::now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
