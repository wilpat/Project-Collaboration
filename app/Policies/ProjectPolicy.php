<?php

namespace App\Policies;

use App\User;
use App\Project;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Project $project){
        return $user->is($project->user) || $project->users->contains($user);
    }

    public function manage(User $user, Project $project){
        return $user->is($project->user);
    }
}
