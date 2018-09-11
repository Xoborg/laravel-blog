<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $post->title }}</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-grey-lightest font-sans leading-normal p-6 text-base text-black md:p12">
	<div class="max-w-lg mx-auto">
		<p class="text-grey-darker">< <a href="{{ route('laravel_blog.frontend.post.index') }}" class="no-underline text-grey-darker hover:underline" title="Blog">Blog</a></p>
		<h1 class="mb-2 text-3xl text-center md:text-5xl">{{ $post->title }}</h1>
		<p class="mb-6 text-center text-grey-darker md:mb-12">By {{ $post->author->user->name }} @ {{ $post->updated_at->format(config('blog.date.format')) }}</p>
		<div class="bg-white p-8 rounded md:text-lg">
			{!! $post->content !!}
		</div>
	</div>
</body>
</html>