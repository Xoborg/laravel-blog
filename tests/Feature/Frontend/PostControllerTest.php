<?php

namespace Xoborg\LaravelBlog\Tests\Feature\Frontend;

use Xoborg\LaravelBlog\Models\Author;
use Xoborg\LaravelBlog\Models\Post;
use Xoborg\LaravelBlog\Tests\TestCase;
use Xoborg\LaravelBlog\Tests\User;

class PostControllerTest extends TestCase
{
	protected function setUp()
	{
		parent::setUp();

		$user = User::create(['email' => 'test@user.com', 'name' => 'Test user']);

		$author = Author::create([
			'user_id' => $user->id
		]);

		$author->posts()
			->createMany([
				[
					'title' => 'Sample title 1',
					'description' => 'Sample post 1',
					'content' => 'Sample content 1',
					'published' => '1'
				],
				[
					'title' => 'Sample title 2',
					'description' => 'Sample post 2',
					'content' => 'Sample content 2',
					'published' => '1'
				],
				[
					'title' => 'Sample title 3',
					'description' => 'Sample post 3',
					'content' => 'Sample content 3',
					'published' => '0'
				]
			]);

	}

	/** @test */
	function it_can_view_post_list()
	{
		$posts = Post::all();

		$publishedPosts = $posts->where('published', true);
		$notPublishedPosts = $posts->where('published', false);

		$this->get(route('laravel_blog.frontend.post.index'))
			->assertOk()
			->assertSeeText($publishedPosts->first()->title)
			->assertDontSeeText($notPublishedPosts->first()->title);
	}

	/** @test */
	function it_can_view_a_post()
	{
		$this->withoutExceptionHandling();

		$post = Post::where('published', true)->first();

		$this->get(route('laravel_blog.frontend.post.show', ['laravelBlogPostSlug' => $post->slug]))
			->assertOk()
			->assertSeeText($post->title);
	}

	/** @test */
	function it_can_not_view_a_not_published_post()
	{
		$post = Post::where('published',false)->first();

		$this->get(route('laravel_blog.frontend.post.show', ['laravelBlogPostSlug' => $post->slug]))
			->assertNotFound()
			->assertDontSeeText($post->title);
	}
}