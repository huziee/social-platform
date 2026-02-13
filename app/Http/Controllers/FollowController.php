<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
     public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Cannot follow yourself'], 403);
        }

        auth()->user()->following()->toggle($user->id);

        return response()->json([
            'status' => 'success',
            'following' => auth()->user()->isFollowing($user->id)
        ]);
    }
}
