<div class="card flex flex-col" style="height: 200px">
	<h3 class="font-normal text-xl py-6 border-l-4 border-blue-light -ml-5 pl-4">
		<a href="{{ $project->path() }}" class="text-black no-underline">
			{{ $project->title }}
		</a>
	</h3>
	<div class="text-grey flex-1">
		{{ str_limit($project->description, 100 ) }}
	</div>
	@can('manage', $project)
		<footer>
			<form method="POST" action="{{$project->path()}}" class="text-right">
				@method('DELETE')
				@csrf
				<button class="text-xs" type="submit">
					Delete
				</button>
			</form>
		</footer>
	@endcan
</div>