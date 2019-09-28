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
    public function only_project_owner_may_invite_users()
    {   
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $project = ProjectFactory::create();
        $cannotInvite = function() use ($user, $project) {
            $this->actingAs($user)
             ->post($project->path().'/invitations')
             ->assertForbidden();
        };

        $cannotInvite();
        
        $project->invite($user);

        $cannotInvite();
    }

    /** @test */
    public function a_project_owner_can_invite_a_user()
    {   
        // $this->withoutExceptionHandling();
        //Create a project
        $project = ProjectFactory::create();

        $newUser = factory(User::class)->create();

        $this->actingAs($project->user)->post($project->path().'/invitations', [
            'email' => $newUser->email
        ])
        ->assertRedirect($project->path());
        $this->assertTrue($project->users->contains($newUser));

    }

    /** @test */
    public function invited_users_may_update_project()
    {   
        // $this->withoutExceptionHandling();
        //Create a project
        $project = ProjectFactory::create();

        $newUser = factory(User::class)->create();

        // Invite a user to the project
        $project->invite($newUser);

        

        //Try to add tasks to the project with this new user signed in
        $this->actingAs($newUser)
             ->post(action('TaskController@store', $project), $task = ['body' => 'Test task']);

        $this->assertDatabaseHas('tasks', $task);

    }

     /** @test */
     public function only_emails_associated_to_collab_accounts_can_be_invited_to_projects()
     {   
        //  $this->withoutExceptionHandling();
         //Create a project
         $project = ProjectFactory::create();
         $this->actingAs($project->user)->post($project->path().'/invitations', [
            'email' => 'some@email.com'
        ])->assertSessionHasErrors([
            'email' => 'Only emails with a collab account can be invited.'
        ], null, 'invitations'); // By default assertSessionHasErrors checks the 'default' error bag, but we changed this in the form request
 
     }
}
