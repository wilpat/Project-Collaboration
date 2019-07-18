<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    use RecordsActivity;

    // We're moving the observer methods to the trait, so we declare the events that we 
    // want the model to trigger a record event to as seen on the task observer
    protected static $recordableEvents = ['created', 'deleted'];

    /**
	* The relationships that should be touched on save
	* 
	* @var array
    */
    protected $touches = ['project'];


    /**
	* The attributes that should be cast to native types
	* 
	* @var array
    */
    protected $casts = ['completed' => 'boolean'];


    /**
	* Getting the owning project
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function project(){
		return $this->belongsTo(Project::class);
	}


	/**
	* Generates and returns the url of the task
	* 
	* @return url string
    */
	public function path(){
		return $this->project->path().'/tasks/'.$this->id;
	}

	/**
	* Marks the task as completed
	* 
    */
	public function complete(){
		$this->update(['completed' => true]);


		$this->recordActivity('completed_task');
	}

	/**
	* Marks the task as incompleted
	* 
    */
	public function incomplete(){
		// dd($this->completed);
		// If the task was updated and the completed status was not changed,
		if($this->wasChanged() && ($this->oldAttributes['completed'] == $this->completed)){
			$this->recordActivity('updated_task');
			// return;
		}else{
			$this->update(['completed' => false]);


			$this->recordActivity('incompleted_task');
		}
	}
}
