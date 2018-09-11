<?php

	Route::group(['prefix' => 'blog/backend', 'middleware' => ['web','can:view-laravel-blog-dashboard']], function () {
		Route::redirect('/', '/blog/backend/post')->name('laravel_blog.backend.index');

		Route::group(['prefix' => 'post'], function () {
			Route::get('/', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@index')->name('laravel_blog.backend.post.index');
			Route::get('new', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@create')->name('laravel_blog.backend.post.create');
			Route::post('new', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@store')->name('laravel_blog.backend.post.store');
			Route::get('{post}/edit', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@edit')->name('laravel_blog.backend.post.edit');
			Route::put('{post}/edit', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@update')->name('laravel_blog.backend.post.update');
			Route::get('{post}/delete', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@destroy')->name('laravel_blog.backend.post.destroy');
		});

		Route::post('post-image', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostImageController@store')
			->middleware(['web','can:view-laravel-blog-dashboard'])
			->name('laravel_blog.backend.post_image.store');
	});

	Route::group(['prefix' => 'blog', 'middleware' => 'bindings'], function () {
		Route::get('/', 'Xoborg\LaravelBlog\Http\Controllers\Frontend\PostController@index')->name('laravel_blog.frontend.post.index');
		Route::get('/{laravelBlogPostSlug}', 'Xoborg\LaravelBlog\Http\Controllers\Frontend\PostController@show')->name('laravel_blog.frontend.post.show');
	});

	Route::bind('laravelBlogPostSlug', function ($laravelBlogPostSlug) {
		return \Xoborg\LaravelBlog\Models\Post::where([['published', true], ['slug', $laravelBlogPostSlug]])->first() ?? abort(404);
	});