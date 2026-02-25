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
        'parent_id' => 'nullable|exists:comments,id', 

    ]);

    // Create comment
    $comment = Comment::create([
        'user_id' => auth()->id(),
        'post_id' => $request->post_id,
        'parent_id' => $request->parent_id, // can be null for main comments
        'comment' => $request->comment,
    ]);

    return response()->json([
        'status' => 'success',
        'comment' => $comment->load('user')
    ]);
}

    public function fetch($postId)
    {
        $comments = Comment::where('post_id', $postId)
            ->whereNull('parent_id') // Only get top-level comments
            ->with(['user', 'replies.user']) // Eager load reply authors
            ->withCount('likes')
            ->latest()
            ->get();

        return response()->json($comments);
    }
    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $comment->delete();
        return response()->json(['success' => true]);
    }

    public function toggleLike($id)
{
    // 1. Ensure the user is logged in
    if (!auth()->check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $comment = Comment::findOrFail($id);
    $user = auth()->user();

    // 2. Use toggle() for the many-to-many relationship
    // This adds a row to 'comment_like' if it doesn't exist, and deletes it if it does.
    $results = $comment->likes()->toggle($user->id);
    
    // 3. Determine if it was an "attach" (liked) or "detach" (unliked)
    $status = count($results['attached']) > 0 ? 'liked' : 'unliked';

    return response()->json([
        'status' => $status,
        'count' => $comment->likes()->count(),
        'isLiked' => $status === 'liked'
    ]);
}

}
