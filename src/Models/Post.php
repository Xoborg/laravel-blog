<?php

namespace Xoborg\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
		'title', 'content'
	];

	protected $table = 'laravel_blog_posts';
}