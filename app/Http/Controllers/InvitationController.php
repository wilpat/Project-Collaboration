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
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);
        return $user;
    }
}