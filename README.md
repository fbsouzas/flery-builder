# Flery-builder

A Laravel package to write, easy and flexible Eloquent query builder.

## Installation
```shell
composer install fbsouzas/flery-builder
```

## Usage

```php
<?php

use Fbsouzas\FleryBuilder\FleryBuilder;
use Illuminate\Http\Request;

return FleryBuilder::to(User::class)
    ->apply($request->all())
    ->get();

// or

return FleryBuilder::to(User::class)
    ->apply([
        'where' => [
            'name' => 'Joe Doe',
        ],
    ])
    ->get();
```

You can use FleryBuilder combine with other Laravel query builder functions.

For example:

```php
<?php

use Fbsouzas\FleryBuilder\FleryBuilder;
use Illuminate\Http\Request;

return FleryBuilder::to(User::class)
    ->apply($request->all())
    ->where(['name' => 'Joe Doe'])
    ->get();

// or

return FleryBuilder::to(User::class)
    ->apply($request->all())
    ->join('contacts', function ($join) {
        $join->on('users.id', '=', 'contacts.user_id')
                ->where('contacts.user_id', '>', 5);
    }))
    ->get();

// or

return FleryBuilder::to(User::class)
    ->apply($request->all())
    ->whereJsonContains('options->languages', ['en', 'br'])
    ->get();

// and etc.
```

## Examples

### Select

```php
// That will return only the user's first name.
GET /api/users?fields=first_name

// or

// That will return only the user's first name and last name.
GET /api/users?fields=first_name,last_name
```

### With

```php
// That will return the user and his contact information.
GET /api/users?with=contact

// or

// That will return the user and his contact information and posts.
GET /api/users?with=contact;posts

// or

// That will return the user and just his posts title.
GET /api/users?with=posts:id,title
```

### Like

```php
// That will return all users that have joe in their first names.
GET /api/users?search[first_name]=joe
```

### Order by

```php
// That will return a user's list ascendant ordered by the first name.
GET /api/users?sort=first_name

// or

// That will return a user's list descendant ordered by the first name.
GET /api/users?sort=-first_name
```

## Requirements
- This package needs PHP 7.4 or above.

## Testing
```shell
composer test
```

## Credits
- [Fábio Souza](https://github.com/fbsouzas)

*This package was inspired by [Spatie's Laravel Query Builder](https://github.com/spatie/laravel-query-builder)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
