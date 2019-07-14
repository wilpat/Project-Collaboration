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

    /** @test */
    public function it_can_complete_a_task()
    {
        $task = factory('App\Task')->create();
        $this->assertFalse($task->completed);

        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    public function it_can_mark_a_task_as_incompleted()
    {
        $task = factory('App\Task')->create(['completed' => true]);
        $this->assertTrue($task->completed);

        $task->incomplete();
        $this->assertFalse($task->fresh()->completed);
    }
}
