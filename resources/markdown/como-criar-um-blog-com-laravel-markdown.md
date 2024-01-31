---
title: Como criar um blog com Laravel e Markdown
image: https://miro.medium.com/v2/resize:fit:640/format:webp/1*sRu7vmmy4QRRKlfTW-hybQ.png
---

Recentemente, eu estava desenvolvendo um blog pessoal e decidi usar o Laravel para criar a aplicação. Eu queria que o blog fosse simples e fácil de usar, então decidi usar o Markdown para escrever os posts. Neste artigo, vou mostrar como você pode criar um blog com Laravel e Markdown, inclusive este post foi escrito em Markdown.

Inicialmente eu não sabia como fazer isso, mas depois de algumas pesquisas, descobri que o Laravel tem um pacote chamado [Laravel Markdown](https://spatie.be/docs/laravel-markdown/v1/introduction) da Spatie que facilita a criação de um blog com Markdown.

Inclusive este pacote já possui um Code Highlighting, que é um recurso que destaca o código dentro do post, dando suporte para alguns Themas conhecidos como: `github`, `Dracula` e muitos outros.

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

### 2.  Criando o Model Post

Agora vamos criar o Model Post, para isso execute o seguinte comando:

```bash
php artisan make:model Post
```

No model é onde vamos deixar a parte mais importante do projeto, que é onde vamos definir o caminho do arquivo Markdown, e o que vamos fazer com ele.

Primeiro vamos criar o metodo find, que vai ser responsável por buscar o arquivo Markdown, e retornar o conteúdo do arquivo.

```php
<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Pagination\{LengthAwarePaginator, Paginator};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

