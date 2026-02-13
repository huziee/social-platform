<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;

use Illuminate\Http\Request;

class LikeController extends Controller
{
     public function togglestatus(Post $post)
    {
        $like = Like::where('user_id', auth()->id())
                    ->where('post_id', $post->id)
                    ->first();

        if ($like) {
            $like->delete();
            $status = 'unliked';
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'count' => $post->likes()->count()
        ]);
    }
}
