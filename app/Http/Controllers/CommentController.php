<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
{
    // Check if user is logged in
    if (!auth()->check()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated'
        ], 401);
    }

    // Validate input
    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'comment' => 'required|string|max:1000',
    ]);

    // Create comment
    $comment = Comment::create([
        'user_id' => auth()->id(),
        'post_id' => $request->post_id,
        'comment' => $request->comment,
    ]);

    return response()->json([
        'status' => 'success',
        'comment' => $comment->load('user')
    ]);
}


    public function fetch($postId)
    {
        return Comment::where('post_id', $postId)
            ->with('user')
            ->latest()
            ->get();
    }
}
