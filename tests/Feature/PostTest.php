<?php

namespace Xoborg\LaravelBlog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Xoborg\LaravelBlog\Models\Post;
use Xoborg\LaravelBlog\Tests\TestCase;
use Xoborg\LaravelBlog\Tests\User;

class PostTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * @var User
	 */
	private $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = User::create(['email' => 'test@user.com', 'name' => 'Test user']);
	}

	/** @test */
	function it_can_create_a_post()
	{
		$this->actingAs($this->user);

		$post = [
			'title' => 'Sample title',
			'content' => 'Sample content'
		];

		$response = $this->from(route('laravel_blog.backend.post.create'))
			->post(route('laravel_blog.backend.post.store'), $post);

		$response->assertRedirect(route('laravel_blog.backend.post.index'))
			->assertSessionHas('status', 'Post created.');

		$this->assertDatabaseHas('laravel_blog_posts', $post);
	}

	/** @test */
	function it_can_not_create_a_post_when_validation_fails()
	{
		$this->actingAs($this->user);

		$response = $this->from(route('laravel_blog.backend.post.create'))
			->post(route('laravel_blog.backend.post.store'), [
				'title' => 'Sample title'
			]);

		$response->assertRedirect(route('laravel_blog.backend.post.create'))
			->assertSessionHasErrors(['content']);

		$this->assertDatabaseMissing('laravel_blog_posts', [
			'title' => 'Sample title',
		]);
	}

	/** @test */
	function it_can_modify_a_post()
	{
		$this->actingAs($this->user);

		$post = Post::create([
			'title' => 'Sample title',
			'content' => 'Sample content'
		]);

		$post->title = 'Title';

		$response = $this->from(route('laravel_blog.backend.post.edit', compact('post')))
			->put(route('laravel_blog.backend.post.update', compact('post')), [
				'title' => $post->title,
				'content' => $post->content
			]);

		$response->assertRedirect(route('laravel_blog.backend.post.index'))
			->assertSessionHas('status', 'Post updated.');

		$this->assertDatabaseHas('laravel_blog_posts', [
			'id' => $post->id,
			'title' => $post->title,
			'content' => $post->content
		]);
	}

	/** @test */
	function it_can_delete_a_post()
	{
		$this->actingAs($this->user);

		$post = Post::create([
			'title' => 'Sample title',
			'content' => 'Sample content'
		]);

		$response = $this->from(route('laravel_blog.backend.post.edit', compact('post')))
			->get(route('laravel_blog.backend.post.destroy', compact('post')));

		$response->assertRedirect(route('laravel_blog.backend.post.index'))
			->assertSessionHas('status', 'Post deleted.');

		$this->assertDatabaseMissing('laravel_blog_posts', $post->toArray());
	}
}