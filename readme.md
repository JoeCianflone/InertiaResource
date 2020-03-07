# Inertia Resource

I wanted a drop-dead simple way to build out resources with Laravel and Inertia and I wasn't happy with all the options that were out there. My main focus was on adding links and meta data to a resource without having to know or care about the structure and I also wanted a super-simple way to hydrate links and I wanted a command to stub out resource files for me, because I'm lazy.

## Usage

Do the composer thing.

Do the `vendor:publish` thing if you want to do that...you don't need to do that though.


## What it looks like

```php

<?php
namespace App\Http\Resources;

use Illuminate\Support\Collection;
use JoeCianflone\InertiaResource\Resource;

class UserResource extends Resource
{
    public function toArray(Collection $resource): array
    {
        return [
            'id' => $resource->get('id'),
            'email' => $resource->get('email'),
        ];
    }

    public static function links(): array
    {
        return [
            'index' => '/users',
            'create' => '/users/create',
            'store' => '/users',
            'show' => '/users/{id}',
            'edit' => '/users/{id}/edit',
            'update' => '/users/{id}',
            'destroy' => '/users/{id}',
        ];
    }

    public static function meta(): array
    {
        return [
            "is_logged_in" => true
        ];
    }

}
```

`links` will pattern match based on keys it finds in your `toArray`.


## Using 

```php

public function __invoke($request) 
{
    $users = new UserResource(EloquentUser::getByEmail($request->email));

    InertiaResponse::view('foo', compact('users'));
}

```

## Commands

Stubbing out a Resource should be kinda easy too.

```
$ php artisan make:inertia-resource Foo
```

That will stub out a file for you called `Foo`. The file will be located in `app/Http/Resources` by default. You've got 2 ways to change that:

1. You can add the path to the `make` command like this:

```
$ php artisan make:inertia-resource Foo /app/Resources
```

2. You can publish the configurations and change the `path` in there.

## Configuration

Run `vendor:publish` and you'll get a file called `inertia-resource` that you can update.This file has a couple of things in it that you can update:

```php
<?php

return [
    'links' => 'links',
    'data' => 'data',
    'meta' => 'meta',
    'path' => '/app/Http/Resources',
    'name_prefix' => '',
    'name_suffix' => '',
];
```

`links`, `data`, and `meta` are related to the names of the object that gets created by InertiaResource. If you don't like those names, feel free to update them here. `path` is related to where the Resource files will be stored on your computer. 

`name_prefix` and `_suffix` are for if you like to name your files using a specific convention. So let's say you like to add the word `Resource` to all your resources...instead of remembering that you can just add it as a `name_suffix` and  then it will just get appended all the time. 

