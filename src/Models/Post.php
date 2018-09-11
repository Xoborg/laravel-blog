<?php

namespace Xoborg\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
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

	public function publishedString(): string
	{
		return $this->published ? 'Published' : 'Not published';
	}

	/**
	 * @return array|\Spatie\Feed\FeedItem
	 */
	public function toFeedItem()
	{
		return FeedItem::create()
			->id($this->id)
			->title($this->title)
			->summary($this->description)
			->updated($this->updated_at)
			->link(route('laravel_blog.frontend.post.show', ['laravelBlogSlug' => $this->slug]))
			->author($this->author->user->name);
	}

	/**
	 * @return mixed
	 */
	public static function getFeedItems()
	{
		return Post::where('published', true)
			->latest()
			->take(config('blog.feed.items'))
			->get();
	}
}