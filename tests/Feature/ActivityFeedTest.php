<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Project;
use App\Activity;
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
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2, $project->activities);
        $this->assertEquals('created_task', $project->activities->last()->description);
        
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
        $project->tasks[0]->incomplete();
        $this->assertCount(3, $project->fresh()->activities);
        $this->assertEquals('incompleted_task', $project->activities->last()->description);
    }
}
