<?php

	/**
	 * 
	 */
	namespace Tests\Setup;
	use App\Project;
	use App\User;
	use App\Task;


	class ProjectFactory
	{
		protected $tasksCount = 0;

		protected $user;

		public function withTasks($count){
			$this->tasksCount = $count;

			return $this; // This is needed for the class to work because we want a fluent apc_inc(key)

						  // It's because we use this class in a way where we chain functions together, so after each function, it makes sense
						  // To return the class again with it's current state to be used in performing the next set of functions
		}

		public function ownedBy($user){ //Used in Feature TaskTest.php
			$this->user = $user;

			return $this; // This is needed for the class to work, dunno why yet
		}

		function create(){
			$project = factory(Project::class)->create([
                'user_id' => $this->user ?: factory(User::class)->create()
			]);

			factory(Task::class, $this->tasksCount)->create([
				'project_id' => $project->id
			]);

			return $project;
		}
	}

?>