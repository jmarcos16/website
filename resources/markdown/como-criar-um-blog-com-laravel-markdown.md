---
title: Como criar um blog com Laravel e Markdown
image: https://raw.githubusercontent.com/jmarcos16/hey-professor/develop/public/Captura%20de%20tela%202024-02-01%20142130.png
---

Recentemente, eu estava desenvolvendo um blog pessoal e decidi usar o Laravel para criar a aplicação. Eu queria que o blog fosse simples e fácil de usar, então decidi usar o Markdown para escrever os posts. Neste artigo, vou mostrar como você pode criar um blog com Laravel e Markdown, inclusive este post foi escrito em Markdown.

Inicialmente eu não sabia como fazer isso, mas depois de algumas pesquisas, descobri que o Laravel tem um pacote chamado [Laravel Markdown](https://spatie.be/docs/laravel-markdown/v1/introduction) da Spatie que facilita a criação de um blog com Markdown.

Inclusive este pacote já possui um Code Highlighting, que é um recurso que destaca o código dentro do post, dando suporte para alguns Themas conhecidos como: **Github themer**, **Dracula** e muitos outros.

### Os pacoetes que vamos utilizar

- [Laravel Markdown](https://spatie.be/docs/laravel-markdown)
- [Yaml Front Matter](https://spatie.be/docs/yaml-front-matter)

Inicialmente criei um projeto Laravel do zero, e instalei o [Tailwind CSS](https://tailwindcss.com/) para estilizar a aplicação.

<!-- https://tailwindcss.com/docs/typography-plugin -->
É importante resaltar que o Tailwind CSS possui um plugin chamado [Typography](https://tailwindcss.com/docs/typography-plugin) que facilita a interpretação do Markdown, para esse caso é necessário instalar o plugin.

### 1. Instalando o Laravel Markdown e o Yaml Front Matter

Para instalar o Laravel Markdown, e o Yaml Front Matter, execute o seguinte comando:

```bash
composer require spatie/laravel-markdown
composer require spatie/yaml-front-matter
```

### 2. Criando class para ler os arquivos Markdown

Depois de instalar os pacotes, vamos criar uma class chamada **MarkDownParse.php** que será responsável por ler os arquivos Markdown, eu coloquei ela no seguinte caminho **app/Services/MarkDownParse.php**.

```php
<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

protected Filesystem $fileSystem;

public function __construct(Filesystem $fileSystem)
{
    $this->fileSystem = $fileSystem;
}

```

Nesse exemplo, estamos utilizando a classe **Filesystem** do Laravel para ler os arquivos Markdown, e o construtor da classe **MarkDownParse** recebe um objeto **Filesystem** que será injetado automaticamente pelo Laravel.

O primeiro metodo que vamos criar é o **find()** que será responsável por encontrar os arquivos Markdown no diretório **resources/markdown** , esse diretório será criado manualmente, será onde iremos escreve nossos markdowns.

```php 

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

```

Nesse método, estamos verificando se o arquivo existe, e se existir, estamos utilizando o pacote **Yaml Front Matter** para fazer o parse do arquivo, e retornar um objeto com as informações do post.

Em seguida, vamos criar o método **all()** que será responsável por retornar todos os arquivos Markdown do diretório `resources/markdown`.

```php
public function all(): Collection
{
    $posts = collect($this->fileSystem->allFiles(resource_path('markdown')))->sortByDesc(function ($file) {
        return $file->getMTime();
    });

    return $posts->map(function ($post) {
        return $this->find($post->getFilename());
    });
}
```

Nesse método, estamos utilizando a classe **Collection** do Laravel para retornar todos os arquivos Markdown do diretório **resources/markdown**, e em seguida, estamos utilizando o método **map()** para retornar um objeto com as informações de cada post, como você pode notar utilizamos também o método **find()** que criamos anteriormente.

Com esses dois metodos conseguimos ler os arquivos Markdown, e também retornar todos os arquivos Markdown do diretório **resources/markdown**, porem vamos incluir mais um método que será o **paginate()** que será responsável por paginar os posts, primeiro vamos criar uma funcão protegida chamada **paginator()** ele criar uma instancia do **LengthAwarePaginator** do Laravel.

```php
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
```

Agora eu vou criar um metodo **simplePaginate()** que será responsável por paginar os posts.

```php
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
```

Com esse método, estamos utilizando a classe **Paginator** do Laravel para paginar os posts, e retornar um objeto **LengthAwarePaginator**.

### 3. Configurando nossas rotas

Agora que já temos a classe **MarkDownParse** pronta, vamos configurar nossas rotas, basicamente vamos criar duas rotas, uma para listar todos os posts, e outra para exibir um post específico, o nosso arquivo **routes/web.php** ficará assim:

```php
use Illuminate\Support\Facades\Route;

Route::get('posts/{slug}', function (MarkDownParse $markdown, $slug) {
    return view('posts.show', [
        'post' => $markdown->find($slug . '.md')
    ]);
})->name('posts.show');

Route::get('posts', function (MarkDownParse $markdown){
    return view('posts.index', [
        'posts' => $markdown->simplePaginate(9)
    ]);
})->name('posts.index');
```

Caso você queira, pode criar um controller para tratar as requisições, mas para esse exemplo vamos utilizar as funções anônimas.