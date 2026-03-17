<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\FollowRequest;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $auth = auth()->user();

        if ($user->id === $auth->id) {
            return response()->json(['error' => 'Cannot follow yourself'], 403);
        }

        $requested = false;

        if ($user->is_private) {
            if ($auth->isFollowing($user->id)) {
                $auth->following()->detach($user->id);
                $following = false;
            } else {
                $existing = FollowRequest::where('requester_id', $auth->id)
                    ->where('target_id', $user->id)
                    ->first();

                if ($existing) {
                    $existing->delete();
                    $following = false;
                    $requested = false;
                } else {
                    FollowRequest::create([
                        'requester_id' => $auth->id,
                        'target_id' => $user->id,
                    ]);
                    $following = false;
                    $requested = true;
                }
            }
        } else {
            $auth->following()->toggle($user->id);
            $following = $auth->isFollowing($user->id);
        }

        $targetFollowers = $user->followers()->count();
        $authFollowing = $auth->following()->count();
        $authFollowers = $auth->followers()->count();

        $toastTitle = $following ? 'Following' : ($requested ? 'Request Sent' : 'Unfollowed');
        $toastMessage = $following
            ? 'Now following @' . $user->username . '.'
            : ($requested ? 'Follow request sent to @' . $user->username . '.' : 'Unfollowed @' . $user->username . '.');

        return response()->json([
            'status' => 'success',
            'following' => $following,
            'requested' => $requested,
            'target_id' => $user->id,
            'target_username' => $user->username,
            'auth_username' => $auth->username,
            'target_followers_count' => $targetFollowers,
            'auth_id' => $auth->id,
            'auth_following_count' => $authFollowing,
            'auth_followers_count' => $authFollowers,
            'toast' => [
                'type' => $following ? 'info' : ($requested ? 'info' : 'warning'),
                'title' => $toastTitle,
                'message' => $toastMessage,
            ],
        ]);
    }

    public function removeFollower(User $user)
    {
        $auth = auth()->user();

        // Remove $user from my followers list
        $auth->followers()->detach($user->id);

        return response()->json([
            'status' => 'success',
            'removed_id' => $user->id,
            'removed_username' => $user->username,
            'auth_username' => $auth->username,
            'auth_id' => $auth->id,
            'auth_followers_count' => $auth->followers()->count(),
            'auth_following_count' => $auth->following()->count(),
            'toast' => [
                'type' => 'warning',
                'title' => 'Follower Removed',
                'message' => 'Removed @' . $user->username . '.',
            ],
        ]);
    }

    public function acceptRequest(User $user)
    {
        $auth = auth()->user();

        $request = FollowRequest::where('requester_id', $user->id)
            ->where('target_id', $auth->id)
            ->firstOrFail();

        $auth->followers()->syncWithoutDetaching([$user->id]);
        $request->delete();

        return response()->json([
            'status' => 'success',
            'following' => true,
            'requested' => false,
            'target_id' => $auth->id,
            'target_username' => $auth->username,
            'auth_id' => $auth->id,
            'target_followers_count' => $auth->followers()->count(),
            'auth_followers_count' => $auth->followers()->count(),
            'auth_following_count' => $auth->following()->count(),
            'toast' => [
                'type' => 'success',
                'title' => 'Request Accepted',
                'message' => 'Accepted @' . $user->username . '.',
            ],
        ]);
    }

    public function declineRequest(User $user)
    {
        $auth = auth()->user();

        FollowRequest::where('requester_id', $user->id)
            ->where('target_id', $auth->id)
            ->delete();

        return response()->json([
            'status' => 'success',
            'following' => false,
            'requested' => false,
            'target_id' => $auth->id,
            'target_username' => $auth->username,
            'auth_id' => $auth->id,
            'target_followers_count' => $auth->followers()->count(),
            'auth_followers_count' => $auth->followers()->count(),
            'auth_following_count' => $auth->following()->count(),
            'toast' => [
                'type' => 'warning',
                'title' => 'Request Declined',
                'message' => 'Declined @' . $user->username . '.',
            ],
        ]);
    }
}
