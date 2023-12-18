---
title: Lorem ipsum dolor sit amet - dowandanwdnawdoi daiondoianwdoa
image: https://source.unsplash.com/random/800x600
date: 2021-01-01
---

<!-- # Lorem ipsum dolor sit amet -->

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl.

```php
    <?php
    use App\Models\User;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });
```

## Lorem ipsum dolor sit amet

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl.

### Lorem ipsum dolor sit amet

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl.

#### Lorem ipsum dolor sit amet

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{

    public function index(): View
    {
        $posts = new Post();

        return view('posts.index', [
            'posts' => $posts->all()
        ]);
    }

    public function show(string $slug): View
    {
        $post = new Post;

        return view('posts.show', [
            'post' => $post->find($slug. '.md')
        ]);
    }
}

```

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl.
