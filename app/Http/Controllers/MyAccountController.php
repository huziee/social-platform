<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class MyAccountController extends Controller
{
    protected function getUserPosts()
    {
        return Post::with(['media', 'user', 'likes', 'comments.user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function index()
    {
        $posts = $this->getUserPosts();

        // Add this line to fetch followers for the connections partial
    $followers = auth()->user()->followers()->with('followers')->get();

        return view('main.content.myProfile.index', compact('posts', 'followers'));
    }

    public function posts()
    {
        $posts = $this->getUserPosts();

        return view('main.content.myProfile.index', [
            'section' => 'posts',
            'posts' => $posts,
        ]);
    }

    public function connections()
{
    $posts = $this->getUserPosts();
    // Fetch the authenticated user's followers
    $followers = auth()->user()->followers()->with('followers')->get();

    return view('main.content.myProfile.index', [
        'section' => 'connections',
        'posts' => $posts,
        'followers' => $followers, // Pass this to the view
    ]);
}

    public function about()
    {
        $posts = $this->getUserPosts();

        return view('main.content.myProfile.index', [
            'section' => 'about',
            'posts' => $posts,
        ]);
    }

    public function privacyTerms() {

        return view('main.content.privacy-&-terms.index');
    }

    public function help() {

        return view('main.content.help.index');
    }

    public function chat() {


        return view('main.content.messages.index');

    }
    

    public function show($username)
{
    // 1. Find the user by username
    $user = User::where('username', $username)->firstOrFail();

    // 2. If it's the logged-in user, redirect to 'my-profile'
    if (auth()->check() && auth()->user()->username === $username) {
        return redirect()->route('profile.index');
    }

    // 3. Fetch that specific user's posts
    $posts = Post::with(['media', 'user', 'likes', 'comments.user'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

    // 4. Return a separate view for public profiles
    return view('main.content.userProfile.show', compact('user', 'posts'));
}

}
