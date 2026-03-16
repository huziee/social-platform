<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['status' => 'error'], 401);
        }

        $user->savedPosts()->toggle($post->id);
        $saved = $user->savedPosts()->where('post_id', $post->id)->exists();

        return response()->json([
            'status' => 'success',
            'saved' => $saved,
            'saved_count' => $user->savedPosts()->count(),
        ]);
    }
}
