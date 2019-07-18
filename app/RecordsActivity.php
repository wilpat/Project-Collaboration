<?php

namespace App;

#This is a trait used in Model and Project Model
trait RecordsActivity
{

	/**
	* Stores the model's old attributes before updating
	* 
	* @var array
    */
    public $old = [];


    // Using a boot method in a trait requires you to follow the convention of boot, followed by the trait name

    /**
     * Overrides / Handles the model's "updating" event.
     *
     * @param  \App\Model $model
     * @return void
     */
    public static function bootRecordsActivity(){

    	static::updating(function($model){
    		$model->old = $model->getOriginal();
    	});

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
	        	'changes' => $this->activityChanges(),
        		'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id

	        ]
        );
    }

    /**
	* Fetch the activityChanges on the model
	* 
	* @return array|null
    */
    public function activityChanges() {
    	if($this->wasChanged()) { // Because we don't want it triggered when a record is created, only when it's updated
    		return [
	        		'before' => array_diff($this->old, $this->getAttributes()),
	        		'after' => array_diff($this->getAttributes(), $this->old),
	        	];
    	}
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