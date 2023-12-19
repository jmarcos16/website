---
title: Como utilizar Enums dentro do Laravel
image: https://miro.medium.com/v2/resize:fit:1400/1*LRwxMPJQTq4v5Ta6zZkpzw.png
---

De fato a utilização de enums pode facilitar muito o desenvolvimento de uma aplicação, principalmente quando se trata de um sistema que possui muitos status, como por exemplo, um sistema de pedidos, onde cada pedido pode ter um status diferente, como: "Aguardando Pagamento", "Em Separação", "Em Transporte", "Entregue", etc.

No **PHP-8.1** foi incluído o suporte nativo a enums, e o Laravel oferece uma integração muito boa com essa funcionalidades como tantas outras.

### Obeservações

- Para esse exemplo foi utilizado um projeto [Laravel](https://laravel.com/docs) 10.x, com o kit [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze). 
- Foi instalado junto ao Breeze o [Tailwind CSS](https://tailwindcss.com/), para facilitar a estilização do projeto.
- O banco de dados utilizado foi o [SQLite](https://www.sqlite.org/index.html), que já vem configurado por padrão no Laravel.
- Foi instalado o [Laravel Livewire](https://livewire.laravel.com/), para facilitar a criação de componentes reativos.
- Para acessar o código fonte do projeto, [clique aqui](#).


### Sobre o projeto
O projeto é bem simples, e consiste em um simple Todo List, onde o usuário pode criar tarefas, e cada tarefa pode ter um status diferente, como: "A fazer", "Em andamento", "Concluída", etc.

### 1 - Criando o Model

Para criar o model, basta executar o comando:

```bash
php artisan make:model Task
```
Va até o arquivo `app/Models/Task.php` e adicione o seguinte código:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
    ];

}
```

### 2 - Criando a Migration

Para criar a migration, basta executar o comando:

```bash
php artisan make:migration create_tasks_table
```

Va até o arquivo <kbd>database/migrations/2021_10_10_000000_create_tasks_table.php</kbd> e adicione o seguinte código:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('status');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
```
### 3 - Criando a Enum de Status

Nesse caso será necessário criar o arquivo manuamente, pois não existe um comando para criar enums no Laravel, então vamos criar o arquivo dentro da nossa pasta <kbd>\App\Enums\StatusEnum.php</kbd>, e adicionar o seguinte código:

```php
<?php
namespace App\Enums;

enum StatusEnum:string
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const DONE = 'done';

    public function label()
    {
        return match ($this) {
            self::PENDING => 'A fazer',
            self::IN_PROGRESS => 'Em progresso',
            self::DONE => 'Feito',
        };
    }

    public function color()
    {
        return match ($this) {
            self::PENDING => 'red',
            self::IN_PROGRESS => 'yellow',
            self::DONE => 'green',
        };
    }
}
```
Tanto o label quanto color, são métodos que podem ser utilizados para facilitar a exibição dos dados na view, como por exemplo, para exibir o status de uma tarefa, podemos utilizar o método `label()` para exibir o nome do status, e o método `color()` para exibir a cor do status.

### 4 - Criando o livewire component

Para criar o livewire component, basta executar o comando:

```bash
php artisan make:livewire tasks.index
```
Esse comando gerará dois arquivos, um arquivo de view <kbd>resources/views/livewire/tasks/index.blade.php</kbd> e um arquivo de classe <kbd>app/Livewire/Tasks/Index.php</kbd>.

Va até o arquivo <kbd>app/Livewire/Tasks/Index.php</kbd> e adicione o seguinte código:

```php
<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.tasks.index',[
            'tasks' => \App\Models\Task::all(),
        ]);
    }
}
```

No arquivo <kbd>resources/views/livewire/tasks/index.blade.php</kbd> adicione o seguinte código:

```blade
<div class="flex flex-col">
    <div class="flex flex-row items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Criar Tarefa</a>
    </div>
    <div class="flex flex-col">
        @foreach ($tasks as $task)
            <div class="flex flex-row items-center justify-between py-2 border-b border-gray-200">
                <div class="flex flex-row items-center">
                    <div class="w-4 h-4 rounded-full bg-{{ $task->status->color() }} mr-2"></div>
                    <p class="text-lg">{{ $task->title }}</p>
                </div>
                <div class="flex flex-row items-center">
                    <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Editar</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 ml-2 text-white bg-red-500 rounded-md hover:bg-red-600">Excluir</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
```

### 5 - Gerando Tasks de exemplo

Para facilitar a nossa vida vamos utilizar o [Laravel Factory](https://laravel.com/docs/8.x/database-testing#generating-factories) para gerar algumas tasks de exemplo, para isso vamos executar o comando:

```bash
php artisan make:factory TaskFactory --model=Task
```
Vamos até o arquivo <kbd>database/faactories/TaskFactory.php</kbd> e adicionar o seguinte código:

```php
<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'status' => $this->faker->randomElement(StatusEnum::cases()['value']),
        ];
    }
}
```	

Agora vamos até o arquivo <kbd>database/seeders/DatabaseSeeder.php</kbd> e adicionar o seguinte código:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Task::factory()->count(20)->create();
    }
}
```

Agora vamos executar o comando para gerar as tasks de exemplo:

```bash
php artisan migrate // Caso ainda não tenha executado, para criar as tabelas no banco de dados
php artisan db:seed
```








