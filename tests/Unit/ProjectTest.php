<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function it_has_a_path()
    {

    	//Given tha we have a project
    	$project = factory('App\Project')->create();

    	//Check that there is a method in the model that generates it's path properly
        $this->assertEquals('/project/' . $project->id, $project->path());
    }

    /** @test */
    public function a_project_has_a_user_relationship()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->user);//THis is how you handle a belongsTo r/ship
    }
}
