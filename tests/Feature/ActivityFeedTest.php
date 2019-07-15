<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Project;
use App\Activity;
use App\Task;
use Facades\Tests\Setup\ProjectFactory; #Enables us use the ProjectFactory class directly without needing the path to it
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function a_project_creation_records_an_activity()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities[0]->description);
        
    }

    /** @test */
    public function a_project_update_records_an_activity()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $project->update( ['title' => 'changed'] );

        // We should find one activity for the project creation, and the project update
        // Activity creation resulting from the project creation is triggered by the project observer
        $this->assertCount(2, $project->activities);
        $this->assertEquals('updated', $project->activities->last()->description);
        
    }

    /** @test */
    public function a_task_creation_records_an_activity()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2, $project->activities);
        tap($project->activities->last(), function($activity) use ($project){
            $this->assertEquals('created_task', $activity->description);
            //Assert that subject column for this activity was populated by the Task Model
            //Certifying that this activity was triggered by a task related action
            // This is laravel's polymorphic relationship
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals($project->tasks[0]->body, $activity->subject->body);

        });
        
    }

    /** @test */
    public function a_task_completion_records_an_activity()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks[0]->complete();
        $this->assertCount(3, $project->fresh()->activities);
        $this->assertEquals('completed_task', $project->activities->last()->description);
    }

    /** @test */
    public function a_task_incompletion_records_an_activity()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        // Decided to go through the url this time
        $this->actingAs($project->user)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->fresh()->activities);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);
        
        $this->assertCount(4, $project->activities);

        $this->assertEquals('incompleted_task', $project->fresh()->activities->last()->description);
    }
}
