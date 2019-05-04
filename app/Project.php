<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path(){

		return '/project/'.$this->id;
	}

	public function user(){
    	return $this->belongsTo(User::class);
    }
}
