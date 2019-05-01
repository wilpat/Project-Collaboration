<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Projects</title>
</head>
<body>

	<h1>Birdboard</h1>
	<ul>
		@forelse ($projects as $project)
			<li> 
				<a href="{{ $project->path() }}">{{ $project->title }}</a>
			</li>
		@empty
			<li>No projects at the moment</li>
		@endforelse
	</ul>
</body>
</html>