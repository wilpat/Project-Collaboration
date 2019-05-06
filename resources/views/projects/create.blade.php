@extends('layouts.app')
@section('content')
	<form method="POST" action="/projects/">
		@csrf
	<h1 class="heading is-1">Create project</h1>
		<div class="field">
		  <label class="label">Title</label>
		  <div class="control">
		    <input class="input" type="text" placeholder="Title" name="title">
		  </div>
		</div>


		<div class="field">
		  <label class="description">Description</label>
		  <div class="control">
			<textarea class="textarea" placeholder="Project description" name="description"></textarea>
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