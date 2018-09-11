@extends('laravel-blog::backend.layout')

@section('content')
	<div class="flex justify-between items-center mb-10">
		<h1 class="font-bold text-grey-darker tracking-wide uppercase">Posts</h1>
		<a href="{{ route('laravel_blog.backend.post.create') }}" class="bg-green no-underline p-3 rounded text-white hover:bg-green-light" title="Create post">Create post</a>
	</div>
	@if($posts->count() > 0)
		<div class="bg-grey-lighter border-b-2 border-grey flex font-bold p-4 rounded-tl rounded-tr text-grey-dark text-sm tracking-wide uppercase">
			<p class="flex-grow text-left">Title</p>
			<p class="flex-no-shrink text-center w-48">Author</p>
			<p class="flex-no-shrink text-center w-32">Last update</p>
			<p class="flex-no-shrink text-center w-32">Status</p>
		</div>

		@foreach($posts as $post)
			<a href="{{ route('laravel_blog.backend.post.edit', compact('post')) }}" class="flex items-center no-underline p-4 text-black hover:bg-grey-lightest" title="{{ $post->title }}">
				<p class="flex-grow truncate">{{ $post->title }}</p>
				<p class="flex-no-shrink text-center truncate w-48">{{ $post->author->user->name }}</p>
				<p class="flex-no-shrink text-center w-32">{{ $post->updated_at->format(config('blog.date.format')) }}</p>
				<p class="flex-no-shrink text-center w-32"><span class="inline-block p-2 rounded {{ $post->published ? 'bg-green-lightest text-green-darkest' : 'bg-red-lightest text-red-darker' }}">{{ $post->publishedString() }}</span></p>
			</a>
		@endforeach

		@if(($posts->onFirstPage() && $posts->hasMorePages()) || !$posts->onFirstPage())
			<div class="pt-12 text-center">
				@if($posts->onFirstPage())
					<span class="bg-grey-lightest inline-block mr-6 p-3 rounded text-grey w-32">< Previous</span>
				@else
					<a href="{{ $posts->previousPageUrl() }}" class="border border-green inline-block mr-6 no-underline p-3 rounded text-green-dark w-32 hover:bg-green hover:text-white" title="Previous">< Previous</a>
				@endif
				
				@if($posts->hasMorePages())
					<a href="{{ $posts->nextPageUrl() }}" class="border border-green inline-block no-underline p-3 rounded text-green-dark w-32 hover:bg-green hover:text-white" title="Next">Next ></a>
				@else
					<span class="bg-grey-lightest inline-block p-3 rounded text-grey w-32">Next ></span>
				@endif
			</div>
		@endif
	@else
		<div class="p-10 rounded text-center">
			<p class="mb-3 text-lg">There aren't any post created.</p>
			<a href="{{ route('laravel_blog.backend.post.create') }}" class="bg-green inline-block no-underline p-3 rounded text-white hover:bg-green-light" title="Create post">Create post</a>
		</div>
	@endif
@endsection