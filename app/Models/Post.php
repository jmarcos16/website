<?php

namespace App\Models;

use App\Entity\PostEntity;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public $filenames;

    public function __construct()
    {
        $this->filenames = collect(File::allFiles(resource_path('markdown')))
            ->sortByDesc(function ($file) {
                return $file->getBaseName();
            })
            ->map(function ($file) {
                return $file->getBaseName();
            });
    }

    public function all()
    {

        $posts = $this->filenames->map(function ($filename) {
            return $this->find($filename);
        });

        return collect($posts);
    }

    public function find(string $filename): PostEntity
    {
        $post   = new PostEntity();
        $file   = resource_path('markdown' . DIRECTORY_SEPARATOR . $filename);
        $object = YamlFrontMatter::parseFile($file);

        $post->title      = $object->title;
        $post->body       = $object->body();
        $post->slug       = explode('.', $filename)[0];
        $post->image      = $object->image;
        $post->created_at = Carbon::parse(File::lastModified($file))
                    ->locale('pt-br')
                    ->translatedFormat('d F Y');

        return $post;
    }
}
