<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();
        $this->assertInstanceOf('App\Project', $task->project);
    }


    /** @test */
    public function it_has_a_path()
    {
        $task = factory('App\Task')->create();
        $this->assertEquals($task->project->path().'/tasks/'.$task->id, $task->path());
    }
}
