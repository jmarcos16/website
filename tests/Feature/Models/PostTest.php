<?php

it('should be able find a post', function () {

    $mardown = <<<MARKDOWN 
        ---
        title: Post 1
        image: post-1.jpg
        ---
        Post 1 body
        MARKDOWN;

    dd($mardown);

    $post = new \App\Models\Post();
    $post = $post->find('post-1.md');

    expect($post->title)->toBe('Post 1');
    expect($post->body)->toBe('Post 1 body');
    expect($post->slug)->toBe('post-1');
    expect($post->image)->toBe('post-1.jpg');
    expect($post->created_at)->toBe('01 de janeiro de 2021');
});