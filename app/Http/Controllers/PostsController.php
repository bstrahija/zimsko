<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);

        return redirect()->to(\App\Services\Settings::get('general.facebook'));
        // return view('pages.posts', ['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('pages.post', ['post' => $post]);
    }
}
