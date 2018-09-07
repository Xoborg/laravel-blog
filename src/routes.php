<?php

	Route::group(['prefix' => 'blog/backend', 'middleware' => ['auth', 'bindings', 'can:view-laravel-blog-dashboard']], function () {
		Route::get('/')->name('laravel_blog.backend.post.index');
		Route::get('post')->name('laravel_blog.backend.post.create');
		Route::post('post', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@store')->name('laravel_blog.backend.post.store');
		Route::get('post/{post}/edit')->name('laravel_blog.backend.post.edit');
		Route::put('post/{post}/edit', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@update')->name('laravel_blog.backend.post.update');
		Route::get('post/{post}/delete', 'Xoborg\LaravelBlog\Http\Controllers\Backend\PostController@destroy')->name('laravel_blog.backend.post.destroy');
	});

	Route::group(['prefix' => 'blog', 'middleware' => 'bindings'], function () {
		Route::get('/')->name('laravel_blog.frontend.post.index');
	});