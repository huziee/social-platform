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

        $following = auth()->user()->isFollowing($user->id);
        $targetFollowers = $user->followers()->count();
        $authFollowing = auth()->user()->following()->count();
        $authFollowers = auth()->user()->followers()->count();

        return response()->json([
            'status' => 'success',
            'following' => $following,
            'target_id' => $user->id,
            'target_followers_count' => $targetFollowers,
            'auth_id' => auth()->id(),
            'auth_following_count' => $authFollowing,
            'auth_followers_count' => $authFollowers
        ]);
    }
}
