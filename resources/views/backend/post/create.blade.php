@extends('laravel-blog::backend.layout')

@section('scripts')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.12.0/trix.css">
	<script type="text/javascript" src="https://unpkg.com/trix@0.12.0/dist/trix.js"></script>
	<script type="text/javascript">
		var csrf = "{{ csrf_token() }}";
		var baseUrl = "{{ route('laravel_blog.backend.index') }}/";
	</script>
	<script type="text/javascript" src="{{ asset('vendor/laravel-blog/js/trix-image-upload.js') }}"></script>
@endsection


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
	<form id="formPost" action="{{ route('laravel_blog.backend.post.store') }}" method="post">
		{{ @csrf_field()  }}
		<label for="title" class="block mb-2">Title</label>
		<input type="text" name="title" id="title" maxlength="60" class="border-2 border-grey block mb-4 outline-none p-3 rounded w-full focus:border-green{{ $errors->has('title') ? ' border-red' : '' }}" value="{{ old('title') }}">
		<label for="description" class="block mb-2">Description</label>
		<input type="text" name="description" id="description" maxlength="250" class="border-2 border-grey block mb-4 outline-none p-3 resize-none rounded w-full focus:border-green{{ $errors->has('description') ? ' border-red' : '' }}" value="{{ old('description') }}">
		<label for="content" class="block mb-2">Content</label>
		<input name="content" id="content" type="hidden" value="{{ old('content') }}">
		<trix-editor input="content" class="trix-content border-2 border-grey block mb-4 outline-none p-3 resize-none rounded w-full focus:border-green{{ $errors->has('content') ? ' border-red' : '' }}" style="min-height: 320px;"></trix-editor>
		<div class="flex items-center justify-end">
			<div class="mr-6">
				<label>
					<select name="published" id="published">
						<option value="1"{{ old('published') == 1 ? ' selected' : '' }}>Published</option>
						<option value="0"{{ old('published') == 0 ? ' selected' : '' }}>Not published</option>
					</select>
				</label>
			</div>
			<button type="submit" class="bg-green border-0 no-underline p-3 rounded text-white hover:bg-green-light">Create</button>
		</div>
	</form>
@endsection