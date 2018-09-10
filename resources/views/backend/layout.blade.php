<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }}</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
	@yield('scripts')
</head>
<body class="bg-grey-lighter border-t-4 border-green font-sans text-base text-black">
	<div class="bg-white mb-12 p-4">
		<div class="container flex justify-between mx-auto p-4">
			<a href="{{ route('laravel_blog.backend.index') }}" class="no-underline text-black" title="{{ config('app.name').' - Blog' }}">{{ config('app.name').' - Blog' }}</a>
			<ul class="flex list-reset">
				<li class="pr-3"><a href="{{ route('laravel_blog.backend.post.index') }}" class="no-underline text-black hover:underline" title="Posts">Posts</a></li>
				<li><a href="#" class="no-underline text-black hover:underline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">Logout</a></li>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">{{ @csrf_field() }}</form>
			</ul>
		</div>
	</div>
	<div class="container mx-auto">
		<div class="bg-white p-8 rounded">
			@yield('content')
		</div>
	</div>
</body>
</html>