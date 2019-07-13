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
    public function a_project_creation_generates_an_activity()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities[0]->description);
        
    }

    /** @test */
    public function a_project_update_generates_an_activity()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $project->update( ['title' => 'changed'] );
        $this->assertCount(2, $project->activities);
        $this->assertEquals('updated', $project->activities->last()->description);
        
    }
}
