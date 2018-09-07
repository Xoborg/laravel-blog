<?php

namespace Xoborg\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
		'title',
		'content',
		'description',
		'published'
	];

	protected $casts = [
		'published' => 'boolean'
	];

	protected $table = 'laravel_blog_posts';

	public function setTitleAttribute($value)
	{
		$this->attributes['title'] = $value;
		$this->attributes['slug'] = str_slug($value);
	}

	public function author()
	{
		return $this->belongsTo(Author::class);
	}
}