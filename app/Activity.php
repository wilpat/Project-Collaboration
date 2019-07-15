<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /**
     * Get the owning model.
     */
    public function subject() {
    	return $this->morphTo();
    }

}
