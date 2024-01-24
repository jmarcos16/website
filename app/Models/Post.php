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
    /**
     * Get all posts.
     *
     * @return Collection<PostEntity>
     */
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

    /**
     * Find a post by filename.
     *
     * @param string $filename
     *
     * @return PostEntity
     */
    public function find(string $filename): PostEntity
    {
        $post = new PostEntity();
        $file = resource_path('markdown' . DIRECTORY_SEPARATOR . $filename);

        File::exists($file) ? $object = YamlFrontMatter::parseFile($file) : abort(404);

        $post->title      = $object->title;
        $post->body       = $object->body();
        $post->slug       = explode('.', $filename)[0];
        $post->image      = $object->image;
        $post->created_at = Carbon::parse(File::lastModified($file))
                    ->locale('pt-br')
                    ->translatedFormat('d F Y');

        return $post;
    }

    /**
     * Paginate posts.
     *
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
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

    /**
     * Paginate posts.
     *
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
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

    /**
     * Create a new length-aware paginator instance.
     *
     * @param Collection $items
     * @param int        $total
     * @param int        $perPage
     * @param int        $currentPage
     * @param array      $options
     *
     * @return LengthAwarePaginator
     */
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

    /**
     * Search posts.
     *
     * @param string $query
     * @param int    $perPage
     *
     * @return LengthAwarePaginator
     */
    public function search(string $query, int $perPage = 10): LengthAwarePaginator
    {
        $posts = $this->all()->filter(function ($post) use ($query) {
            return str_contains(strtolower($post->title), strtolower($query));
        });

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

}
