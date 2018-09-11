<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ config('app.name').' - Blog' }}</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-grey-lightest font-sans leading-normal p-6 text-base text-black md:p-12">
	<div class="max-w-md mx-auto">
		<h1 class="mb-6 text-center md:mb-12">{{ config('app.name').' - Blog' }}</h1>
		<div class="bg-white mb-6 p-8 rounded md:mb-12">
			@foreach($posts as $post)
				<div{!! !$loop->last ? ' class="border-b pb-6 mb-6"' : '' !!}>
					<p class="font-light italic text-grey-dark text-sm">{{ $post->updated_at->format('d/m/Y') }}</p>
					<h3 class="mb-2"><a href="{{ route('laravel_blog.frontend.post.show', ['laravelBlogSlug' => $post->slug]) }}" class="no-underline text-2xl text-black hover:underline" title="{{ $post->title }}">{{ $post->title }}</a></h3>
					<p>{{ $post->description }}</p>
				</div>
			@endforeach
		</div>
		@if(($posts->onFirstPage() && $posts->hasMorePages()) || !$posts->onFirstPage())
			<div class="text-center">
				@if($posts->onFirstPage())
					<span class="bg-grey-lighter inline-block mr-2 p-2 rounded text-grey w-32 md:mr-6 md:p-3">< Previous</span>
				@else
					<a href="{{ $posts->previousPageUrl() }}" class="border border-grey-dark inline-block mr-2 no-underline p-2 rounded text-grey-darker w-32 hover:bg-grey-darkest hover:text-white md:mr-6 md:p-3" title="Previous">< Previous</a>
				@endif

				@if($posts->hasMorePages())
					<a href="{{ $posts->nextPageUrl() }}" class="border border-grey-dark inline-block no-underline p-2 rounded text-grey-darker w-32 hover:bg-grey-darkest hover:text-white md:p-3" title="Next">Next ></a>
				@else
					<span class="bg-grey-lighter inline-block p-2 rounded text-grey w-32 md:p-3">Next ></span>
				@endif
			</div>
		@endif
	</div>
</body>
</html>