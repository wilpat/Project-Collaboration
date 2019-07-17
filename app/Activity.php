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

}
