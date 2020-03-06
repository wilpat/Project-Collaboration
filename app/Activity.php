<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = ['changes' => 'array'];


    /**
     * Make the created_at timestamp human readable
     *
     * @param  date  $created_at
     * @return string
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->diffForHumans();
    }

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
