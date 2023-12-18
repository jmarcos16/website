<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = new Post();

        return view('posts.index', [
            'posts' => $posts->simplePaginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $post = new Post();

        return view('posts.show', [
            'post' => $post->find($slug . '.md'),
        ]);
    }
}
