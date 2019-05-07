<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path(){

		return '/projects/'.$this->id;
	}

	public function addTask($body){

		return $this->tasks()->create(compact('body'));

	}

	public function tasks(){
		return $this->hasMany(Task::class);
	}

	public function user(){
    	return $this->belongsTo(User::class);
    }
}
