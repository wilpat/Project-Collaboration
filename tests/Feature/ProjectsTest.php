<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory; #Enables us use the ProjectFactory class directly without needing the path to it
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        // $this->withoutExceptionHandling();
        $project = factory(Project::class)->create();

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
    public function a_user_can_update_a_project()
    {   
        $this->withoutExceptionHandling();
        /*
            Refactor
            // If i am signed
            $this->signIn();
            //And a project exists that was created by me
            $project = auth()->user()->projects()->create(
                factory(Project::class)->raw()
            );
        */
        $project = ProjectFactory::create();
        // If i post a project update request
        $this->actingAs($project->user)
             ->patch($project->path(), $attributes = ['notes' => 'Changed', 'title' => 'Changed', 'description' => 'Changed'])
             ->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }


    /** @test */
    public function a_user_can_update_a_project_note()
    {   
        $project = ProjectFactory::create();
        $this->actingAs($project->user)
             ->patch($project->path(), $attributes = ['notes' => 'Changed'])
             ->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function a_user_can_view_their_project(){

       /* 
        Refactor
        // Given that i am logged in
        $this->signIn();
        //Given that I have a project created with my id associated with it
        $project = factory(Project::class)->create(['user_id' => auth()->id()]); // This automatically persists the record
        */
        $project = ProjectFactory::create();
        // When i visit the page of the project
        $this->actingAs($project->user)
             ->get($project->path())
             ->assertSee($project->title) // Check that we have it's title and description rendered on the page
             ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others(){

        // Given that i am logged in
        $this->signIn();
        //Given that I have a project created without my id associated with it
        $project = factory(Project::class)->create(); // This automatically persists the record

        // When i visit the page of the project
        $this->get($project->path())
             ->assertForbidden(403);
    }

    /** @test */
    public function a_user_can_view_create_projects_page()
    {
        // $this->withoutExceptionHandling();
        
        // Given that i am signed in,
        $res = $this->signIn();
        // dd(auth()->id());
        // Check that we the title of the project gets rendered on the projects page 
        $this->get('/projects/create')->assertStatus(200);
        // $this->get('/projects/create')->assertSee('Create');

    }

     /** @test */
    public function a_user_can_create_projects()
    {
        // $this->withoutExceptionHandling();

        //If i am logged in
        $this->signIn();

        //If i hit the create url, i get a page there
        $this->get('/projects/create')->assertOk();

        // Assumming the form is ready, if i get the form data
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];
        // dd(auth()->id());
        // dd($this->grabDataFromResponseByJsonPath('$.id'));
        //If we submit the form data, 
        $response = $this->post('/projects', $attributes);

        //Get the project we just created
        $project = Project::where($attributes)->first();

        // Check that we get redirected to the projects path
        $response->assertRedirect($project->path());

        // Check that we the title of the project gets rendered on the projects page 
        $this->get($project->path())
             ->assertSee($attributes['title'])
             ->assertSee($attributes['description'])
             ->assertSee($attributes['notes']);

    }


    /** @test */
    public function a_project_requires_a_title(){
        $this->signIn();
        $attributes = factory(Project::class)->raw(['title' => '']);// This is because we already created factory data for project in database/factories
                                                                   // We used raw because we needed an array here. the other option 'make' returns an object

        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_decription(){
        $this->signIn();
        $attributes = factory(Project::class)->raw(['description' => '']);

        // If i submit an incomplete dataset, check that it throws an error
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others(){

        // Given that i am logged in
        $this->signIn();
        //Given that I have a project created without my id associated with it
        $project = factory(Project::class)->create(); // This automatically persists the record

        // When i try updating the project
        $this->patch($project->path(), ['notes' => 'Changed'])
             ->assertForbidden();
    }

}
