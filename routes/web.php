<?php

use App\Http\Controllers\{PostController, TestController};
use App\Support\MarkDownParse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('posts/{slug}', function (MarkDownParse $markdown, $slug) {

    $post = $markdown->find($slug . '.md');
    !$post->draft ?: abort(404);
    
    return view('posts.show', [
        'post' => $markdown->find($slug . '.md')
    ]);
})->name('posts.show');

Route::get('posts', function (MarkDownParse $markdown){
    return view('posts.index', [
        'posts' => $markdown->simplePaginate(9)
    ]);
})->name('posts.index');

Route::get('contact', function () {
    return view('contact');
})->name('contact');