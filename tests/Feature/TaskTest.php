<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        // If a project exists
        $project = factory(Project::class)->create();
        //And i am not logged in

        //Then if i try posting a task to that project, 
        // Asser that i was redirected to the login page
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertRedirect('login');


    }

    /** @test */
    public function only_the_project_owner_can_may_add_tasks()
    {   
        //If i am signed
        $this->signIn();

        // If a project is created that doesnt belong to me
        $project = factory(Project::class)->create();
        //And i am not logged in

        //Then if i try posting a task to that project, 
        // Asser that i was get a 403
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);


    }

    /** @test */
    public function only_the_project_owner_can_may_update_its_tasks(){

        // Given that i am logged in
        $this->signIn();
        /* Refactor
            //Given that I have a project created without my id associated with it
            $project = factory('App\Project')->create(); 

            // And a task exists for that project
            $task = $project->addTask('Test task');
        */
        // Create a project and give it it's own user which would be different from me and then a task
        $project = ProjectFactory::withTasks(1)->create(); 


        // If i post a task update request for the task
        $this->patch($project->tasks[0]->path(), ['body' => 'Changed'])
             ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);

    }

    /** @test */
    public function a_user_can_create_tasks()
    {   
        // $this->withoutExceptionHandling();
        /*
        Refactor
            // If i am signed
            $this->signIn();
            //And a project exists that was created by me
            $project = auth()->user()->projects()->create(
                factory(Project::class)->raw()
            );
        */

        $project = ProjectFactory::create(); 
        // If i post a task for creation under that project
        $this->actingAs($project->user)
             ->post($project->path().'/tasks', ['body' => 'Test task']);

        $this->get($project->path())
             ->assertSee('Test task');
    }

    /** @test */
    public function a_user_can_update_tasks()
    {   
        $this->withoutExceptionHandling();
        /*
        Refactoring These
            // If i am signed
            $this->signIn();
            //And a project exists that was created by me
            $project = auth()->user()->projects()->create(
                factory(Project::class)->raw()
            );

            // And a task exists for that project
            $task = $project->addTask('Test task');
        */

        // Into this one-liner and moved all Tests/Setup/ProjectFactory
        // This is because it was being used repeatedly in different tests
        // The class can be called directly like this because we used the Facade above.

        // So this creates the project, gives it a user and a task.

        //Option 1
        // $project = ProjectFactory::withTasks(1)->create();
        // We could also pass in the user this way
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create(); 


        // If i post a task update request
        $this->patch($project->tasks->first()->path(), ['body' => 'Changed']);
        $this->assertDatabaseHas('tasks', ['body' => 'Changed']);

    }

    /** @test */
    public function a_task_requires_a_body(){
        // $this->withoutExceptionHandling();
        
        /*// If i am signed
        $this->signIn();

        //And a project exists that was created by me
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );*/
        $project = ProjectFactory::create(); 

        $attributes = factory('App\Task')->raw(['body' => '']);

        // If i submit an incomplete dataset, check that it throws an error
        $this->actingAs($project->user)
             ->post($project->path() . '/tasks', $attributes)
             ->assertSessionHasErrors('body');

    }
}
