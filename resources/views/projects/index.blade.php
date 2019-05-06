@extends('layouts.app')
@section('content')
	<div class="flex item-centered mb-4" style="justify-content: space-between;">
		<a href="/projects/create">New Project</a>
	</div>
	
	<ul>
		@forelse ($projects as $project)
			<li> 
				<a href="{{ $project->path() }}">{{ $project->title }}</a>
			</li>
		@empty
			<li>No projects at the moment</li>
		@endforelse
	</ul>
@endsection