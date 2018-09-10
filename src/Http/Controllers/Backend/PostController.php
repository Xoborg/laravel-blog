<?php

namespace Xoborg\LaravelBlog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Xoborg\LaravelBlog\Models\Author;
use Xoborg\LaravelBlog\Models\Post;

class PostController extends Controller
{
	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		$title = config('app.name').' - Blog - Posts';

		$posts = Post::with([
			'author',
			'author.user:id,name'
		])
			->latest()
			->simplePaginate(15);

		return view('laravel-blog::backend.post.index', compact('title', 'posts'));
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function create()
	{
		$title = config('app.name').' - Blog - New post';

		return view('laravel-blog::backend.post.create', compact('title'));
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		$validated = $request->validate([
			'title' => 'required|max:60|unique:laravel_blog_posts',
			'description' => 'required|max:250',
			'content' => 'required',
			'published' => 'boolean'
		]);

		Author::where('user_id', $request->user()->id)
			->firstOrFail()
			->posts()
			->create($validated);

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post created.');
	}


	/**
	 * @param Request $request
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Post $post)
	{
		$validated = $request->validate([
			'title' => 'required|max:60|unique:laravel_blog_posts',
			'description' => 'required|max:250',
			'content' => 'required',
			'published' => 'boolean'
		]);

		$post->update($validated);

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post updated.');
	}

	public function destroy(Post $post)
	{
		$post->delete();

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post deleted.');
	}
}
