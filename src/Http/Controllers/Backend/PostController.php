<?php

namespace Xoborg\LaravelBlog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
			->simplePaginate(config('blog.posts.per_page.backend'));

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
			'published' => 'required|boolean'
		]);

		$post = Author::where('user_id', $request->user()->id)
			->firstOrFail()
			->posts()
			->create($validated);

		if ($request->input('image')) {
			$request->validate([
				'image' => 'array'
			]);

			collect($request->input('image'))->each(function ($image) use ($post) {
				if (strpos($post->content, $image) === false) {
					Storage::disk('public')->delete('img/blog/tmp/'.basename($image));
				} else {
					Storage::disk('public')->move('img/blog/tmp/'.basename($image), 'img/blog/'.$post->id.'/'.basename($image));
				}
			});

			$post->content = str_replace('/img/blog/tmp/', '/img/blog/'.$post->id.'/', $post->content);
			$post->save();
		}

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post created.');
	}

	public function edit(Post $post)
	{
		$title = config('app.name').' - Blog - New post';

		return view('laravel-blog::backend.post.edit', compact('post', 'title'));
	}

	/**
	 * @param Request $request
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Post $post)
	{
		$validated = $request->validate([
			'title' => [
				'required',
				'max:60',
				Rule::unique('laravel_blog_posts')->ignore($post->id)
			],
			'description' => 'required|max:250',
			'content' => 'required',
			'published' => 'required|boolean'
		]);

		$post->update($validated);

		if ($request->input('image')) {
			$request->validate([
				'image' => 'array'
			]);

			collect($request->input('image'))->each(function ($image) use ($post) {
				if (strpos($post->content, $image) === false) {
					Storage::disk('public')->delete('img/blog/tmp/'.basename($image));
				} else {
					Storage::disk('public')->move('img/blog/tmp/'.basename($image), 'img/blog/'.$post->id.'/'.basename($image));
				}
			});

			$post->content = str_replace('/img/blog/tmp/', '/img/blog/'.$post->id.'/', $post->content);
			$post->save();
		}

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post updated.');
	}

	/**
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Post $post)
	{
		$post->delete();

		Storage::disk('public')->deleteDirectory('img/blog/'.$post->id);

		return response()->redirectToRoute('laravel_blog.backend.post.index')
			->with('status', 'Post deleted.');
	}
}
