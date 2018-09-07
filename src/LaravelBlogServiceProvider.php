<?php

namespace Xoborg\LaravelBlog;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Xoborg\LaravelBlog\Console\Commands\LaravelBlogCommand;

class LaravelBlogServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
		$this->loadRoutesFrom(__DIR__.'/routes.php');

		if ($this->app->runningInConsole()) {
			$this->commands([
				LaravelBlogCommand::class
			]);
		}
	}

	/**
	 * Register the application services.
	 */
	public function register()
	{

	}
}