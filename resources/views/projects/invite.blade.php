<div class="card flex flex-col mt-4">
	<h3 class="font-normal text-xl py-6 border-l-4 border-blue-light -ml-5 pl-4">
		<p>Invite User</p>
	</h3>

	<form method="POST" action="{{$project->path().'/invitations'}}" class="text-left">
		@csrf
		<div class="mb-3">
			<input type="email" name="email" class="px-3 py-2 border border-grey-light rounded w-full" placeholder="Email address.">
		</div>
		<button class="text-xs button" type="submit">
			Invite
		</button>
		@include('errors', ['bag' => 'invitations'])
	</form>
</div>