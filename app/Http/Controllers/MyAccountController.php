<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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

        return view('main.content.myProfile.index', compact('posts'));
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

        return view('main.content.myProfile.index', [
            'section' => 'connections',
            'posts' => $posts,
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

}
