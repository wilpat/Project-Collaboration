<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_projects()
    {
        // $this->withoutExceptionHandling();
        $attributes = factory('App\Project')->raw();
        
        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $attributes)->assertRedirect('login');

    }

    /** @test */
    public function a_user_can_create_projects()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        //If we submit a project, check that we get redirected to the projects path
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        // check that the database has the data we just submitted
        $this->assertDatabaseHas('projects', $attributes);

        // Check that we the title of the project gets rendered on the projects page 
        $this->get('/projects')->assertSee($attributes['title']);

    }


    /** @test */
    public function a_project_requires_a_title(){
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['title' => '']);// This is because we already created factory data for project in database/factories
                                                                   // We used raw because we needed an array here. the other option 'make' returns an object

        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_decription(){
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']);

        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

    /** @test */
    public function a_user_can_view_a_project(){

        $this->actingAs(factory('App\User')->create());
        //Given that we have a project
        $project = factory('App\Project')->create(); // This automatically persists the record

        // When we visit the page of the projece
        $this->get('/project/' . $project->id)
             ->assertSee($project->title) // Check that we have it's title and description rendered on the page
             ->assertSee($project->description);
    }

}
