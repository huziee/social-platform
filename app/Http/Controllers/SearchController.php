<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function users(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        if ($q === '' || strlen($q) < 2) {
            return response()->json(['users' => []]);
        }

        $users = User::where('id', '!=', auth()->id())
            ->where(function ($query) use ($q) {
                $query->where('username', 'like', '%' . $q . '%')
                    ->orWhere('first_name', 'like', '%' . $q . '%')
                    ->orWhere('last_name', 'like', '%' . $q . '%')
                    ->orWhere('id', $q);
            })
            ->limit(8)
            ->get();

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => trim($user->first_name . ' ' . $user->last_name),
                'username' => $user->username,
                'image' => $user->image ? asset('assets/images/users/' . $user->image) : asset('assets/images/avatar/07.jpg'),
                'profile_url' => route('user.profile', $user->username),
            ];
        });

        return response()->json(['users' => $results]);
    }
}
