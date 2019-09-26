<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory; #Enables us use the ProjectFactory class directly without needing the path to it
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_project_can_invite_users()
    {   
        // $this->withoutExceptionHandling();
        //Create a project
        $project = ProjectFactory::create();

        $newUser = factory(User::class)->create();

        // Invite a user to the project
        $project->invite($newUser);

        $this->signIn($newUser);

        //Try to add tasks to the project with this new user signed in
        $this->post(action('TaskController@store', $project), $task = ['body' => 'Test task']);

        $this->assertDatabaseHas('tasks', $task);

    }
}
