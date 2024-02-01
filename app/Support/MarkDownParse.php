<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\{LengthAwarePaginator, Paginator};
use Illuminate\Support\Collection;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use stdClass;

class MarkDownParse
{
    protected Filesystem $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * Get post content from markdown files.
     *
     * @return stdClass
     */
    public function find(string $filename): stdClass
    {
        $file = resource_path('markdown' . DIRECTORY_SEPARATOR . $filename);

        if ($this->fileSystem->exists($file)) {
            $object = YamlFrontMatter::parseFile($file);

            $post             = new stdClass();
            $post->title      = $object->title;
            $post->body       = $object->body();
            $post->slug       = explode('.', $filename)[0];
            $post->image      = $object->image;
            $post->created_at = Carbon::parse($this->fileSystem->lastModified($file))
                ->locale('pt-br')
                ->translatedFormat('d F Y');

            return $post;
        }
        abort(404);
    }

    /**
     * Get all posts from markdown files.
     *
     * @return Collection
     */

    public function all(): Collection
    {
        $posts = collect($this->fileSystem->allFiles(resource_path('markdown')))->sortByDesc(function ($file) {
            return $file->getMTime();
        });

        return $posts->map(function ($post) {
            return $this->find($post->getFilename());
        });
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

}
