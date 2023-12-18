<?php

namespace App\Models;

use App\Entity\PostEntity;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Pagination\{LengthAwarePaginator, Paginator};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public function all(): Collection
    {
        $posts = collect(File::allFiles(resource_path('markdown')))->sortByDesc(function ($file) {
            return $file->getMTime();
        });

        foreach ($posts as $key => $post) {
            $posts[$key] = $this->find($post->getFilename());
        }

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

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        $posts       = $this->all();
        $currentPage = Paginator::resolveCurrentPage('page');
        $total       = $posts->count();

        return $this->paginator(
            $posts->forPage($currentPage, $perPage),
            $total,
            $perPage,
            $currentPage,
            [
                'path'     => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

    }

    public function simplePaginate(int $perPage = 10): LengthAwarePaginator
    {
        $posts       = $this->all();
        $currentPage = Paginator::resolveCurrentPage('page');
        $total       = $posts->count();

        return $this->paginator(
            $posts->slice(($currentPage - 1) * $perPage, $perPage),
            $total,
            $perPage,
            $currentPage,
            [
                'path'     => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }

    protected function paginator($items, $total, $perPage, $currentPage, $options): LengthAwarePaginator
    {

        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items',
            'total',
            'perPage',
            'currentPage',
            'options'
        ));
    }

}
