<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
        $user = $this->signIn();
    	//Given tha we have a project
        $project = ProjectFactory::ownedBy($user)->create();
        $activity = $project->activities()->latest()->first();

    	//Check that there is a user added to this activity
        $this->assertEquals($user->id, $activity->user->id);
    }
}
