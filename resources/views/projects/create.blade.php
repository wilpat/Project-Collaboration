<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create Project</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
	<!-- Latest CSS files for bulma and font-awesome -->
</head>
<body>

	<form class="container" method="POST" action="/projects/">
		@csrf
	<h1 class="heading is-1" style="padding-top: 40px">Create project</h1>
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
			</div>
		</div>
	</form>
	
</body>
</html>