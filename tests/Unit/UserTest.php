<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    	$user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);//THis is how you handle a hasMany r/ship
    }
}
