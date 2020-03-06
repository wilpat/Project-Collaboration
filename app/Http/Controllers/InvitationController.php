<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvitationRequest;
use App\Project;
use App\User;


class InvitationController extends Controller
{
    public function store(Project $project, InvitationRequest $request)
    {
        // $this->authorize('manage', $project);
        // request()->validate([
        //     'email' => ['required','exists:users,email'] //Email must exist in the users table, specifically in the email column
        // ],[
        //     'email.exists' => 'Only emails with a collab account can be invited.'
        // ]);
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);
        return $user;
    }
}
// Invite@gmail.com