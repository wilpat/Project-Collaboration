<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        // $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        // Given that i am not logged in
        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        // if i try viewing all projects
        $this->get('/projects')->assertRedirect('login');//Assert that i was redirected to the login page
        // IF i go to the project creation page
        $this->get('/projects/create')->assertRedirect('login');//Assert that i was redirected to the login page
        // And if i try viewing the the individual created project
        $this->get($project->path())->assertRedirect('login');//Assert that i was redirected to the login page

    }


    /** @test */
    public function a_user_can_view_their_project(){

        // Given that i am logged in
        $this->be(factory('App\User')->create());
        //Given that I have a project created with my id associated with it
        $project = factory('App\Project')->create(['user_id' => auth()->id()]); // This automatically persists the record

        // When i visit the page of the project
        $this->get($project->path())
             ->assertSee($project->title) // Check that we have it's title and description rendered on the page
             ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others(){

        // Given that i am logged in
        $this->be(factory('App\User')->create());
        //Given that I have a project created without my id associated with it
        $project = factory('App\Project')->create(); // This automatically persists the record

        // When i visit the page of the project
        $this->get($project->path())
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_create_projects_page()
    {
        // $this->withoutExceptionHandling();
        
        // Given that i am signed in,
        $this->actingAs(factory('App\User')->create());
        // Check that we the title of the project gets rendered on the projects page 
        $this->get('/projects/create')->assertStatus(200);
        // $this->get('/projects/create')->assertSee('Create');

    }

     /** @test */
    public function a_user_can_create_projects()
    {
        $this->withoutExceptionHandling();

        //If i am logged in
        $this->actingAs(factory('App\User')->create());

        //If i hit the create url, i get a page there
        $this->get('/projects/create')->assertStatus(200);

        // Assumming the form is ready, if i get the form data
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        // dd(auth()->id());
        //If we submit the form data, check that we get redirected to the projects path
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

}
