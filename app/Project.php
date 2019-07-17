<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

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

    /**
	* Records the activity of a project
	* 
	* @param string $description
    */
    public function recordActivity($description) {
        $this->activities()->create(
        	[
	        	'description' => $description,
	        	'changes' => $this->changes($description)
	        ]
        );
    }

    public function changes($description) {
    	if($description === 'updated') {
    		return [
	        		'before' => array_diff($this->old, $this->getAttributes()),
	        		'after' => array_diff($this->getAttributes(), $this->old),
	        	];
    	}
    }
}
