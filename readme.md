# Inertia Resource

I wanted a drop-dead simple way to build out resources with Laravel and Inertia and I wasn't happy with all the options that were out there. My main focus was on adding links and meta data to a resource without having to know or care about the structure and I also wanted a super-simple way to hydrate links.

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

