<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = ['changes' => 'array'];

    /**
     * Get the owning model.
     */
    public function subject() {
    	return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function username(){
        $username = $this->user->id !== auth()->user()->id ? $this->user->name : 'You';
        return $username;
    }

}
