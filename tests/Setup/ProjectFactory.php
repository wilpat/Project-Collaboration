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

			return $this; // This is needed for the class to work, dunno why yet
		}

		public function ownedBy($user){
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