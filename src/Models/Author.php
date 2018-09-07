<?php

namespace Xoborg\LaravelBlog\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	protected $fillable = [
		'user_id'
	];

	protected $table = 'laravel_blog_authors';

	public function users()
	{
		return $this->hasMany(User::class);
	}
}