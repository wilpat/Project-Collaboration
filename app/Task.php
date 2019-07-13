<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];

    public function project(){
		return $this->belongsTo(Project::class);
	}

	public function path(){
		return $this->project->path().'/tasks/'.$this->id;
	}

	public function complete(){
		$this->update(['completed' => true]);
		$this->project->recordActivity('completed_task');
	}
}
