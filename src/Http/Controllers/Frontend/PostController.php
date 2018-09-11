<?php

namespace Xoborg\LaravelBlog\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Xoborg\LaravelBlog\Models\Post;

class PostController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$posts = Post::where('published', true)
			->latest()
			->simplePaginate(5);

		return view('laravel-blog::frontend.post.index', compact('posts'));
	}

	/**
	 * @param Post $post
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Post $post)
	{
		$post->load([
			'author',
			'author.user:id,name'
		]);

		return view('laravel-blog::frontend.post.show', compact('post'));
	}
}