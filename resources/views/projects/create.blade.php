@extends('layouts.app')
@section('content')
	<form 
		method="POST" 
		action="/projects"
		class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6" 
	>

		@csrf

		<h1 class="text-2xl font-normal mb-10 text-center">
			Let's start something new
		</h1>

		<div class="field mb-6">
		  <label class="label text-sm mb-2 block" title="title">Title:</label>

		  <div class="control">

		    <input 
		    	class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full" 
		    	type="text" 
		    	placeholder="My next awesome project" 
		    	name="title">
		  </div>
		</div>


		<div class="field">
		  <label class="description">Description:</label>
		  <div class="control">
			<textarea 
			class="textarea bg-transparent border border-grey-light rounded p-2 text-ws w-full"
			placeholder="Project description"
			name="description"
			style="min-height: 200px"></textarea>
		  </div>
		</div>
	
		<div class="field">
		  	<div class="control">
			  <button class="button is-primary">Create Project</button>
			  <a href="/projects">Cancel</a>
			</div>
		</div>
	</form>
@endsection