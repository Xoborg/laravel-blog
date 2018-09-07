<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelBlogPostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('laravel_blog_posts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('description');
			$table->text('content');
			$table->string('slug')->unique();
			$table->boolean('published')->default(false);
			$table->unsignedInteger('author_id');
			$table->foreign('author_id')
				->references('id')->on('laravel_blog_authors')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('laravel_blog_posts');
	}
}