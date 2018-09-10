@extends('laravel-blog::backend.layout')

@section('content')
	<div class="flex justify-between items-center mb-10">
		<h1 class="font-bold text-grey-darker tracking-wide uppercase">New post</h1>
		<a href="{{ route('laravel_blog.backend.post.index') }}" class="border no-underline p-3 rounded text-grey-dark hover:bg-grey-lightest" title="Cancel">Cancel</a>
	</div>
	@if ($errors->any())
		<div class="bg-red mb-10 p-4 rounded text-white">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form action="{{ route('laravel_blog.backend.post.store') }}" method="post">
		{{ @csrf_field()  }}
		<label for="title" class="block mb-2">Title</label>
		<input type="text" name="title" id="title" maxlength="60" class="border-2 border-grey block mb-4 outline-none p-3 rounded w-full focus:border-green{{ $errors->has('title') ? ' border-red' : '' }}" value="{{ old('title') }}">
		<label for="description" class="block mb-2">Description</label>
		<input type="text" name="description" id="description" maxlength="250" class="border-2 border-grey block mb-4 outline-none p-3 resize-none rounded w-full focus:border-green{{ $errors->has('title') ? ' border-red' : '' }}">
		<label for="content" class="block mb-2">Content</label>
		<textarea name="content" id="content" class="border-2 border-grey block mb-4 outline-none p-3 resize-none rounded w-full focus:border-green{{ $errors->has('title') ? ' border-red' : '' }}" rows="5"></textarea>
		<div class="flex items-center justify-end">
			<div class="mr-6">
				<label>
					<select name="published" id="published">
						<option value="1">Published</option>
						<option value="0">Not published</option>
					</select>
				</label>
			</div>
			<button type="submit" class="bg-green border-0 no-underline p-3 rounded text-white hover:bg-green-light">Create</button>
		</div>
	</form>
@endsection