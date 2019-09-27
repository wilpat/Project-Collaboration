<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;

class InvitationController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
        request()->validate([
            'email' => 'exists:users,email' //Email must exist in the users table, specifically in the email column
        ],[
            'email.exists' => 'The user you are inviting my have a collab account.'
        ]);
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);
        return redirect($project->path());
    }
}
