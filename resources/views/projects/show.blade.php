@extends('layouts.app')
@section('title')
{{ $project->title }}
@endsection
@section('content')
	
	<header class="py-4">

		<div class="flex items-end justify-between">
			
			<p class="text-grey text-sm font-normal">
				<a href="/projects" class="no-underline text-grey">My Projects</a> / {{ $project->title }}
			</p>

			<a href="/projects/create" class="button">New Project</a>
		</div>

	</header>

	<main>
		<div class="lg:flex -mx-3">
			<div class="lg:w-3/4 px-3">
				<div class="mb-8">

					<h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
					<div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </div>
					<div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </div>
					<div class="card mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </div>
					<div class="card">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </div>

				</div>
				<div class="mb-3">
					<h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>

					<textarea class="card w-full" style="min-height: 200px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </textarea>
				</div>

			</div>

			<div class="lg:w-1/4 px-3">

				@include('projects.card')

			</div>
		</div>
	</main>
	
		
@endsection