<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null){

    	$user = $user ?: factory('App\User')->create();// If you pass a user, user it or create one

    	$this->actingAs($user); // Sign that user in
        
        return $user; // Return the user

    }
}
