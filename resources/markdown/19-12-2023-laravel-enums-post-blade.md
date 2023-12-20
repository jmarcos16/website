---
title: Como implementar níveis de acesso em um sistema Laravel — Laravel 10
image: https://miro.medium.com/v2/resize:fit:640/format:webp/1*sRu7vmmy4QRRKlfTW-hybQ.png
---

Provavelmente você já precisou implementar níveis de acesso em algum sistema que desenvolveu, e se você está aqui, provavelmente está precisando implementar em um sistema Laravel. Então, vamos lá!

Como sabemos o Laravel possui muitos recursos que facilitam o desenvolvimento de sistemas, nesse caso vamos utilizar o recurso de [Gate](https://laravel.com/docs/authorization#gates) que é um recurso que nos permite definir uma lógica de autorização de forma simples e expressiva, também vamos utilizar o [Laravel Auth](https://laravel.com/docs/authentication) que é um recurso que nos permite autenticar usuários de forma simples e rápida.

### Observação

Paga facilitar eu crie um projeto Laravel do zero, mas você pode implementar em qualquer projeto Laravel, lembrando que você pode acessar o código fonte do projeto no [GitHub](https://github.com/jmarcos16/permisson-laravel.git).

### 1. Criando o tabelas

Vamos criar as tabelas que vamos utilizar para implementar o nível de acesso, para isso vamos utilizar o recurso de [Migrations](https://laravel.com/docs/migrations) do Laravel.

```bash
php artisan make:migration create_roles_table
php artisan make:migration create_role_user_table
```

Agora vamos criar as tabelas, para isso vamos utilizar o recurso de [Schema Builder](https://laravel.com/docs/migrations#creating-tables) do Laravel.

```php
// database/migrations/2020_03_29_000000_create_roles_table.php

public function up()
{
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

```php
// database/migrations/2020_03_29_000000_create_role_user_table.php

public function up()
{
    public function up(): void
    {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Role::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_user');
    }
}
```

Nessa situação eu estou utilizando um relacionamento de muitos para muitos, onde um usuário pode ter muitas permissões e uma permissão pode ter muitos usuários.

### 2. Criando as Models

Agora vamos criar as Models que vamos utilizar para implementar o nível de acesso, para isso vamos utilizar o recurso de [Eloquent ORM](https://laravel.com/docs/eloquent) do Laravel.

```bash
php artisan make:model Role
```

```php
// app/Models/Role.php

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
```

```bash
php artisan make:model User
```

```php
// app/Models/User.php

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignRole(string $role): void
    {
        $this->roles()->firstOrCreate(['name' => $role]);

        $this->roles()->attach($role);
    }
}
```

Vamos entender qual a função de cada método da Model User.

- **roles()**: Retorna um relacionamento de muitos para muitos com a Model Role.

- **hasRole()**: Verifica se o usuário possui uma determinada permissão.

- **assignRole()**: Atribui uma permissão para o usuário.

### 3. Criando as Gates

Nesse exemplo vamos criar 2 [Gates](https://laravel.com/docs/authorization#gates), uma para verificar se o usuário é administrador e outra para verificar se o usuário é um usuário comum.

```php

// app/Providers/AuthServiceProvider.php

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user): bool {
            return $user->hasRole('admin');
        });

        Gate::define('user', function (User $user): bool {
            return $user->hasRole('user');
        });
    }
}
```


### Formas de utilizar as Gates

Agora que já criamos as Gates, vamos entender como podemos utilizá-las.

#### 1. Utilizando as Gates no Controller


```php

// app/Http/Controllers/HomeController.php

class HomeController extends Controller
{
    public function index(): View
    {
        if (Gate::allows('admin')) {
            return view('admin');
        }

        if (Gate::allows('user')) {
            return view('user');
        }

        return view('home');
    }
}
```

Vejam que no exemplo acima eu estou utilizando o método [allows()](https://laravel.com/docs/authorization#via-the-user-model) que verifica se o usuário possui uma determinada permissão, caso o usuário possua a permissão ele retorna true, caso contrário ele retorna false.

#### 2. Utilizando as Gates no Blade

```blade

// resources/views/home.blade.php

@if (Gate::allows('admin'))
    <a href="{{ route('admin') }}">Admin</a>
@endif

@if (Gate::allows('user'))
    <a href="{{ route('user') }}">User</a>
@endif

```

Você também pode utilizar o método [can()](https://laravel.com/docs/authorization#via-blade-templates) que verifica se o usuário possui uma determinada permissão, caso o usuário possua a permissão ele retorna true, caso contrário ele retorna false.

```blade

// resources/views/home.blade.php

@can('admin')
    <a href="{{ route('admin') }}">Admin</a>
@endcan

@can('user')
    <a href="{{ route('user') }}">User</a>
@endcan

```


### 4. Utilizando as Gates nas Rotas

O método citado acima **can()** também pode ser utilizado nas rotas, para isso vamos utilizar o recurso de [Route::middleware()](https://laravel.com/docs/routing#route-group-middleware) do Laravel.

```php

// routes/web.php

Route::middleware(['can:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');
});

Route::middleware(['can:user'])->group(function () {
    Route::get('/user', function () {
        return view('user');
    })->name('user');
});

```

Como você pode ver no exemplo acima, eu estou utilizando o método [middleware()](https://laravel.com/docs/routing#route-group-middleware) que verifica se o usuário possui uma determinada permissão, caso o usuário possua a permissão ele retorna true, caso contrário ele retorna false, eu particulamente prefiro utilizar esse método nas rotas, desta forma o sistema bloqueia o acesso a rota caso o usuário não possua a permissão, desta forma caso não possua a permissão o sistema não chama o Controller e nem a View, o que torna o sistema mais seguro.



### Como eu posso atribuir uma permissão para um usuário?

Para atribuir uma permissão para um usuário, basta utilizar o método **assignRole()** que criamos na Model User.

```php

// app/Http/Controllers/HomeController.php

class HomeController extends Controller
{
    public function index(): View
    {
        $user = User::find(1);

        $user->assignRole('admin');

        return view('home');
    }
}
```

Você também pode atribuir uma permissão para um usuário utilizando o método **attach()** que criamos na Model User.

```php

// app/Http/Controllers/HomeController.php

class HomeController extends Controller
{
    public function index(): View
    {
        $user = User::find(1);

        $user->roles()->attach('admin');

        return view('home');
    }
}
```


### Conclusão

Nesse artigo vimos como implementar níveis de acesso em um sistema Laravel utilizando o recurso de [Gate](https://laravel.com/docs/authorization#gates) e [Laravel Auth](https://laravel.com/docs/authentication), também vimos como podemos utilizar as Gates no Controller, Blade e nas Rotas, e por fim vimos como podemos atribuir uma permissão para um usuário.











