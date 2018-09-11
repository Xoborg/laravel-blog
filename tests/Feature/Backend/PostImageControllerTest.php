<?php

namespace Xoborg\LaravelBlog\Tests\Feature\Backend;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Xoborg\LaravelBlog\Models\Author;
use Xoborg\LaravelBlog\Tests\TestCase;
use Xoborg\LaravelBlog\Tests\User;

class PostImageControllerTest extends TestCase
{
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var Author
	 */
	private $author;

	public function setUp()
	{
		parent::setUp();

		$this->user = User::create(['email' => 'test@user.com', 'name' => 'Test user']);

		$this->author = Author::create([
			'user_id' => $this->user->id
		]);
	}

	/** @test */
	function it_can_upload_post_images()
	{
		$this->actingAs($this->user);

		Storage::fake('public');

		$file = UploadedFile::fake()->image('post-image.jpg');

		$response = $this->post(route('laravel_blog.backend.post_image.store'), [
			'image' => $file
		]);

		Storage::disk('public')->assertExists('img/blog/tmp/'.$file->hashName());

		$response->assertOk()
			->assertSeeText(Storage::disk('public')
				->url('img/blog/tmp/'.$file->hashName()));
	}
}