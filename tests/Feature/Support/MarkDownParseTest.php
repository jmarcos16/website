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

it('should be able get all posts', function () {

    $fileSystem = new Filesystem();

    $markdown = new \App\Support\MarkDownParse($fileSystem);
    $posts = $markdown->all();

    expect($posts)->toBeInstanceOf(\Illuminate\Support\Collection::class);
    expect($posts->first())->toHaveProperty('title');
    expect($posts->first())->toHaveProperty('body');
    expect($posts->first())->toHaveProperty('slug');
    expect($posts->first())->toHaveProperty('image');
    expect($posts->first())->toHaveProperty('created_at');
});

it('should be able paginate posts', function () {

    $fileSystem = new Filesystem();

    $markdown = new \App\Support\MarkDownParse($fileSystem);
    $posts = $markdown->simplePaginate(9);

    expect($posts)->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class);
    expect($posts->first())->toHaveProperty('title');
    expect($posts->first())->toHaveProperty('body');
    expect($posts->first())->toHaveProperty('slug');
    expect($posts->first())->toHaveProperty('image');
    expect($posts->first())->toHaveProperty('created_at');
});