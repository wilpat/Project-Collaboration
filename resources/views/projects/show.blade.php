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

			<a href="/projects/{{ $project->id }}/edit" class="button">Edit Project</a>
		</div>

	</header>

	<main>
		<div class="lg:flex -mx-3">
			<div class="lg:w-3/4 px-3">
				<div class="mb-8">

					<h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>

					@foreach ($project->tasks as $task)
						<div class="card mb-3">
							<form action="{{ $task->path() }}" method="POST">
								@method('PATCH')
								@csrf
								<div class="flex">
									<input class="w-full {{ $task->completed ? 'text-grey' : '' }}" type="text" name="body" value="{{ $task->body }}" /> 
									<input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}/>
								</div>

							</form>
						</div>
					@endforeach

					<form action="{{ $project->path() . '/tasks' }}" method="POST">
						@csrf
						<input class="card mb-3 w-full" type="text" placeholder="Add a new task..." name="body">
					</form>

				</div>
				<div class="mb-3">
					<h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
					<form action="{{ $project->path() }}" method="POST">
						@csrf
						@method('PATCH')
						<textarea name ="notes" class="card w-full" style="min-height: 200px" placeholder="Anything special you want to take note of?">{{ $project->notes }}</textarea>
						<input type="submit" class="button">
					</form>
				</div>

			</div>

			<div class="lg:w-1/4 px-3">

				@include('projects.card')

			</div>
		</div>
	</main>
	
		
@endsection