<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public $old = [];

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
		// var_dump($this->old);
		if($this->old && ($this->old['completed'] == $this->completed)){
			$this->recordActivity('updated_task');
			// return;
		}else{
			$this->update(['completed' => false]);


			$this->recordActivity('incompleted_task');
		}
	}

	/**
	* Records the activity of a task
	* 
	* @param string $description
    */
    public function recordActivity($description) {
        $this->activities()->create([
        	'description' => $description,
        	'project_id' => $this->project_id
        ]);
    }

    /**
	* Getting the owning activity model
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
	public function activities(){
		return $this->morphMany(Activity::class, 'subject')->latest();
	}
}
