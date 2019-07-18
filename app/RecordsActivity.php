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
    public $oldAttributes = [];


    // Using a boot method in a trait requires you to follow the convention of boot, followed by the trait name

    /**
     * Boot the trait.
     * Overrides / Handles the model's "updating" event.
     *
     * @param  \App\Model $model
     * @return void
     */
    public static function bootRecordsActivity(){
    	// static here refers to the model calling this trait

    	//Set a method to be called when the model is updating-- this is cos both project and task use this logic
    	static::updating(function($model){
    		$model->oldAttributes = $model->getOriginal();
    	});

    	foreach (self::recordableEvents() as $event) {
    		static::$event(function($model) use($event) {

    			$model->recordActivity($model->activityDescription($event));
    		});
    	}
    }

    /**
     * Get the desctiption of the activity
     *
     * @param  string $description
     * @return string
     */
    protected function activityDescription($description){

		return "{$description}_".strtolower(class_basename($this)); // created_task, created_user, created_file etc

    }


    /**
	* Fetch the model events that should trigger activity
	* 
	* @return array
    */
    protected static function recordableEvents(){

    	// Register the model events actions here instead of using an observer
    	if(isset(static::$recordableEvents)){
    		// If this model already has the recordable events set, use it else use the default 
    		return static::$recordableEvents;
    	}
    	
    	return ['created','updated','deleted'];

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
	* Getting the owning activity model
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
	public function activities(){
		return $this->morphMany(Activity::class, 'subject')->latest();
	}

    /**
	* Fetch the activityChanges on the model
	* 
	* @return array|null
    */
    public function activityChanges() {
    	if($this->wasChanged()) { // Because we don't want it triggered when a record is created, only when it's updated
    		return [
	        		'before' => array_diff($this->oldAttributes, $this->getAttributes()),
	        		'after' => array_diff($this->getAttributes(), $this->oldAttributes),
	        	];
    	}
    }

}