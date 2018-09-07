<?php

namespace Xoborg\LaravelBlog\Tests\Console;

use Xoborg\LaravelBlog\Models\Author;
use Xoborg\LaravelBlog\Tests\TestCase;
use Xoborg\LaravelBlog\Tests\User;

class LaravelBlogCommandTest extends TestCase
{
	/**
	 * @var User
	 */
	private $user;

	protected function setUp()
	{
		parent::setUp();

		$this->user = User::create(['email' => 'test@user.com', 'name' => 'Test user']);
	}

	/** @test */
	function it_can_add_a_user()
	{
		$this->artisan('laravel-blog:author', [
			'--add' => null,
			'userId' => $this->user->id
		])
			->expectsOutput('User added')
			->assertExitCode(0);

		$this->assertDatabaseHas('laravel_blog_authors', [
			'user_id' => $this->user->id
		]);
	}

	/** @test */
	function it_can_not_add_a_user_if_is_already_an_author()
	{
		Author::create([
			'user_id' => $this->user->id
		]);

		$this->artisan('laravel-blog:author', [
			'--add' => null,
			'userId' => $this->user->id
		])
			->expectsOutput('  The user is already an author  ')
			->assertExitCode(0);

		$this->assertEquals(1, Author::where('user_id', $this->user->id)->count());
	}

	/** @test */
	function it_can_not_add_a_user_if_the_user_does_not_exists()
	{
		$this->artisan('laravel-blog:author', [
			'--add' => null,
			'userId' => 5
		])
			->expectsOutput('  The user does not exists in the DB  ')
			->assertExitCode(0);

		$this->assertDatabaseMissing('laravel_blog_authors', [
			'user_id' => $this->user->id
		]);
	}

	/** @test */
	function it_can_remove_a_user()
	{
		Author::create([
			'user_id' => $this->user->id
		]);

		$this->artisan('laravel-blog:author', [
			'--remove' => null,
			'userId' => $this->user->id
		])
			->expectsOutput('User removed')
			->assertExitCode(0);

		$this->assertDatabaseMissing('laravel_blog_authors', [
			'user_id' => $this->user->id
		]);
	}

	/** @test */
	function it_can_not_remove_a_user_if_is_not_already_an_author()
	{
		$this->artisan('laravel-blog:author', [
			'--remove' => null,
			'userId' => $this->user->id
		])
			->expectsOutput('  The user is not an author  ')
			->assertExitCode(0);
	}
}