<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
	use RecordsActivity; // This is a trait stored in App\RecordsActivity

    protected $guarded = [];

    /**
	* Generates the url of the project
	* 
	* @return url string
    */

    public function path(){

		return '/projects/'.$this->id;
	}

	/**
	* Adds a task to the project
	* 
	* @param string $body
	* 
	* @return \Illuminate\Database\Eloquent\Relations\Many
    */

	public function addTask($body){

		return $this->tasks()->create(compact('body'));

	}

	/**
	* The tasks of the project
	* 
	* @return \Illuminate\Database\Eloquent\Relations\Many
    */

	public function tasks(){
		return $this->hasMany(Task::class);
	}

	/**
	* Gets the owning user
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
	public function user(){
    	return $this->belongsTo(User::class);
    }

    /**
	* The activity feed for the project
	* 
	* @return \Illuminate\Database\Eloquent\Relations\Many
    */
    public function activities() {
    	return $this->hasMany(Activity::class)->latest();
	}
	
	public function invite(User $user)
	{

		return $this->users()->attach($user);
	}

	public function users()
	{
		// Many to many r/ship 
		return $this->belongsToMany(User::class, 'project_users')->withTimestamps();
	}
}
