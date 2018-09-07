<?php

namespace Xoborg\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	protected $fillable = [
		'user_id'
	];

	protected $table = 'laravel_blog_authors';

	public function user()
	{
		return $this->belongsTo(config('auth.providers.users.model'));
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}