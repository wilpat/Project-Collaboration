<?php

namespace Tests\Unit;
use Facades\Tests\Setup\ProjectFactory; #Enables us use the ProjectFactory class directly without needing the path to it


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_has_projects_relationship()
    {
    	$user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->projects);//THis is how you handle a hasMany r/ship
    }

    /** @test */
    public function a_user_has_accessible_projects()
    {

        $samson = factory(User::class)->create();
        $william = factory(User::class)->create();
        $gary = factory(User::class)->create();

        $samsonsProject = tap(ProjectFactory::ownedBy($samson)->create())->invite($gary);

        $this->assertCount(1, $gary->accessibleProjects());
        $this->assertCount(0, $william->accessibleProjects());
        $samsonsProject->invite($william);
        $this->assertCount(1, $william->accessibleProjects());


    }
}
