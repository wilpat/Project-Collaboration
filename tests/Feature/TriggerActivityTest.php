<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Project;
use App\Activity;
use App\Task;
use Facades\Tests\Setup\ProjectFactory; #Enables us use the ProjectFactory class directly without needing the path to it
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activities);
         tap($project->activities->last(), function($activity){
            
            // Assert that no change was recorded, because our logic updated the changes column of the activity table
            $this->assertNull($activity->changes);
            $this->assertEquals('created_project', $activity->description);
        });
        
    }

    /** @test */
    public function updating_a_project()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update( ['title' => 'changed'] );

        // We should find one activity for the project creation, and the project update
        // Activity creation resulting from the project creation is triggered by the project observer
        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function($activity) use($originalTitle){
            $this->assertEquals('updated_project', $activity->description);
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
        
    }

    /** @test */
    public function creating_a_task()
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
    public function completing_a_task()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks[0]->complete();
        // dd($project->fresh()->activities->toArray());
        $this->assertCount(3, $project->fresh()->activities);
        $this->assertEquals('completed_task', $project->activities->last()->description);
    }

    /** @test */
    public function incompleting_a_task()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        // Decided to go through the url this time
        $this->actingAs($project->user)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        // dd($project->fresh()->activities->toArray());
        $this->assertCount(3, $project->fresh()->activities);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);
        
        $this->assertCount(4, $project->activities);
        $this->assertEquals('incompleted_task', $project->fresh()->activities->last()->description);
    }
}
