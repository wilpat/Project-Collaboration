<?php

namespace App\Http\Controllers;
use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Project $project){
    	// if(auth()->user()->isNot($project->user)){
        //     abort(403);
        // }
        $this->authorize('update', $project);
    	request()->validate([
            'body' => 'required',
        ]);

    	$response = $project->addTask(request('body'));

    	return $response;
    }


    /**
    * Updates the project
    * 
    * @param Project $project
    * @param Task    $task
    * @return \Illuminate\Http\RedirectResponse
    * @throws \Illuminate\Auth\Access\AuthorizationException
    */
    public function update(Project $project, Task $task){
    	// if(auth()->user()->isNot($task->project->user)){
    	// 	abort(403);
    	// }

        $this->authorize('update', $task->project);

        $attributes = request()->validate(['body' => 'required']);

        $task->update($attributes);
        request('completed') ? $task->complete() : $task->incomplete();
        
    	return $task;
    }
}
