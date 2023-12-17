---
title: Como execular arquivos PHP no Laravel
image: https://source.unsplash.com/random/800x600
---

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl. Sed euismod, nisl eget ultricies aliquam, nunc nisl ultricies nisi, vitae ultricies nisl nisl vitae nisl.

```php
<?php
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```