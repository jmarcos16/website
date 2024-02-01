<?php

use Illuminate\Filesystem\Filesystem;

it('should be able parse markdown', function () {

    $fileSystem = new Filesystem();

    $markdown = new \App\Support\MarkDownParse($fileSystem);
    $posts = collect($fileSystem->allFiles(resource_path('markdown')))->sortByDesc(function ($file) {
        return $file->getMTime();
    });

    $post = $markdown->find($posts->first()->getFilename());

    expect($post)->toHaveProperty('title');
    expect($post)->toHaveProperty('body');
    expect($post)->toHaveProperty('slug');
    expect($post)->toHaveProperty('image');
    expect($post)->toHaveProperty('created_at');
});