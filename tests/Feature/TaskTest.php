<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
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
    public function a_user_can_create_tasks()
    {   
        // $this->withoutExceptionHandling();
        // If i am signed
        $this->signIn();
        //And a project exists that was created by me
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        // If i post a task for creation under that project
        $this->post($project->path().'/tasks', ['body' => 'Test task']);

        $this->get($project->path())
             ->assertSee('Test task');
    }

    /** @test */
    public function a_task_requires_a_body(){
        // $this->withoutExceptionHandling();
        
        // If i am signed
        $this->signIn();

        //And a project exists that was created by me
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        // If i submit an incomplete dataset, check that it throws an error
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');

    }
}
