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
}
