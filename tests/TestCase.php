<?php

namespace Xoborg\LaravelBlog\Tests;

use Illuminate\Database\Schema\Blueprint;
use \Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
	protected function setUp()
	{
		parent::setUp();
		$this->setUpDatabase($this->app);
	}

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'testbench');
		$app['config']->set('database.connections.testbench', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		]);
	}

	/**
	 * @param \Illuminate\Foundation\Application $app
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [
			\Xoborg\LaravelBlog\LaravelBlogServiceProvider::class
		];
	}

	public function setUpDatabase($app)
	{
		$app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email');
			$table->string('name');
		});
	}
}