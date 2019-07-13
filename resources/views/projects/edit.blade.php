@extends('layouts.app')
@section('content')

<form 
	method="POST" 
	action="{{ $project->path() }}"
	class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6" 
>
	@method('PATCH')
	<h1 class="text-2xl font-normal mb-10 text-center">
		Edit Project
	</h1>
	@include('projects.form', ['buttonText' => 'Update Project'])
</form>
@endsection
