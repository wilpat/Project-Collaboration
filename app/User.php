<?php

namespace App;
use App\Project;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects() {
        return $this->hasMany(Project::class)->latest('updated_at');
    }

    public function accessibleProjects()
    {
        return Project::where('user_id', $this->id)
            ->orWhereHas('users', function($query) { // Because projects has a belongsToMany relationship with users
                $query->where('user_id', $this->id);
            })
            ->get();
    }
}
