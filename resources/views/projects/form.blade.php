@csrf

<div class="field mb-6">
  <label class="label text-sm mb-2 block" title="title">Title:</label>

  <div class="control">

    <input 
    	class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full" 
    	type="text" 
    	placeholder="My next awesome project" 
    	name="title"
    	value="{{ $project->title }}"
    	required 
    	>
  </div>
</div>


<div class="field">
  <label class="description">Description:</label>
  <div class="control">
	<textarea 
	class="textarea bg-transparent border border-grey-light rounded p-2 text-ws w-full"
	placeholder=""
	name="description"
	style="min-height: 200px"
	required>{{ $project->description }}</textarea>
  </div>
</div>

<div class="field">
  	<div class="control">
	  <button class="button is-primary">{{ $buttonText }}</button>
	  <a href="{{ $project->path() }}">Cancel</a>
	</div>
</div>

@if($errors->any())
	<div class="field mt-6">
		@foreach($errors->all() as $error)
			<li class="text-sm text-red">{{ $error }}</li>
		@endforeach
	</div>
@endif