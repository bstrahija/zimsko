<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);

        return view('posts.index', ['posts' => $posts]);
    }

    public function show($post)
    {
        return view('posts.show', ['post' => $post]);
    }
}
