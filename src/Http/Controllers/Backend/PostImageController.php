<?php

namespace Xoborg\LaravelBlog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'image' => 'required|image'
		]);

		$image = $request->file('image');

		$image->store('img/blog/tmp', 'public');

		return response(Storage::disk('public')->url('img/blog/tmp/'.$image->hashName()));
	}
}