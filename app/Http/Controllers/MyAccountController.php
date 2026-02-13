<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    public function index()
{
    return view('main.content.myProfile.index');
}
    public function posts()
    {
        return view('main.content.myProfile.index', [
            'section' => 'posts'
        ]);
    }

    public function connections()
    {
        return view('main.content.myProfile.index', [
            'section' => 'connections'
        ]);
    }

    public function about()
    {
        return view('main.content.myProfile.index', [
            'section' => 'about'
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
