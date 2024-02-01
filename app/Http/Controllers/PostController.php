<?php

namespace App\Http\Controllers;

use App\Support\MarkDownParse;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(MarkDownParse $markdown): View
    {
        return view('posts.index', [
            'posts' => $markdown->simplePaginate(9),
        ]);
    }

    public function show(MarkDownParse $markdown, string $slug): View
    {
        return view('posts.show', [
            'post' => $markdown->find($slug . '.md'),
        ]);
    }
}
