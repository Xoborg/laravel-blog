# A simple blog package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/xoborg/laravel-blog.svg?style=flat-square)](https://packagist.org/packages/xoborg/laravel-blog)
[![Total Downloads](https://img.shields.io/packagist/dt/xoborg/laravel-blog.svg?style=flat-square)](https://packagist.org/packages/xoborg/laravel-blog)
[![License](https://img.shields.io/packagist/l/xoborg/laravel-blog.svg?style=flat-square)](https://github.com/Xoborg/laravel-blog/blob/master/LICENSE.md)

## Installation

You can install the package via composer:

```bash
composer require xoborg/laravel-blog
```

This package uses Laravel's authentication scaffold, so if you don't already have it set-up just run `php artisan make:auth`.

Then execute `php artisan migrate` to create laravel-blog and Laravel tables.

Next, you must publish the config file:

```php
php artisan vendor:publish --provider="Xoborg\LaravelBlog\LaravelBlogServiceProvider" --tag="config"
```

Finally, you need to publish a necessary JavaScript file for the Backend:

```php
php artisan vendor:publish --provider="Xoborg\LaravelBlog\LaravelBlogServiceProvider" --tag="public" --force
```

## Usage

Your blog will be installed in `http://your-app.test/blog` but you wont be able to publish posts until you are added as author, to do that you can use:

``` php
php artisan laravel-blog:author --add 1 // User ID
```

Then, if you are logged in to your app, you will be able to access the admin panel located in `http://your-app.test/blog/backend`. 

### Other commands

To remove a user as an author run:

``` php
php artisan laravel-blog:author --remove 1 // User ID
```

You also can see an author list:

``` php
php artisan laravel-blog:author --list
```

### Customize the views

If you want to customize the backend or frontend views of this package, publish the views files with the next command:

```php
php artisan vendor:publish --provider="Xoborg\LaravelBlog\LaravelBlogServiceProvider" --tag="views"
```

### RSS feed

Laravel Blog has support for [spatie/laravel-feed](https://github.com/spatie/laravel-feed) package to generate a RSS feed of your blog, 

Register the routes the feeds will be displayed on using the feeds-macro.

```php
// In routes/web.php
Route::feeds();
```

Next, you must publish the config file:

```php
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="config"
```

Then you need to specify in this config file which class and method will return the items that should appear in the feed:

```php
...
'items' => 'Xoborg\LaravelBlog\Models\Post@getFeedItems',
...
```

If you want feed readers to discover your feed, you should publish Laravel Blog views and add this in the `<head>` tag:

```php
 @include('feed::links')
```

Finally, you can set the number of items that will be displayed in the feed by changing it in `config/blog.php`:

```php
...
'feed' => [
	/**
	 * The number of items that should appear in the feed
	 */
	'items' => 25
]
...
```

## Testing

``` bash
composer test
```

## Security

If you discover any security related issues, please email developers@xoborg.com instead of using the issue tracker.

## Credits

- [Carlos Rodríguez](https://github.com/carlosre)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.