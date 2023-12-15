<?php

namespace App\Models;

use App\Entity\PostEntity;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public function all()
    {
        $posts = collect(File::allFiles(resource_path('markdown')))->each(function ($filename) {
            return $this->find($filename->getFilename());
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
