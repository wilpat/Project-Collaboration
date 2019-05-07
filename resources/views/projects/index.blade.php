@extends('layouts.app')
@section('content')
	<header class="py-4">

		<div class="flex items-end justify-between">
			
			<h2 class="text-grey text-sm font-normal">My Projects</h2>

			<a href="/projects/create" class="button">New Project</a>
		</div>

	</header>
	
	<main class="lg:flex lg:flex-wrap -mx-3">
		@forelse ($projects as $project)
			<div class="lg:w-1/3 px-3 pb-6">
				@include('projects.card')
			</div>
		@empty
			<li>No projects at the moment</li>
		@endforelse
	</main>
	
@endsection
