<?php

namespace App\Http\Controllers;
use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Project $project){
    	if(auth()->user()->isNot($project->user)){
            abort(403);
        }
    	request()->validate([
            'body' => 'required',
        ]);

    	$project->addTask(request('body'));

    	return redirect($project->path());
    }

    public function update(Project $project, Task $task){
    	// if(auth()->user()->isNot($task->project->user)){
    	// 	abort(403);
    	// }

        $this->authorize('update', $task->project);

        $attributes = request()->validate(['body' => 'required']);
    	$task->update($attributes);
        $method = request('completed') ? 'complete' : 'incomplete';

        $task->$method();
        
    	return redirect($project->path());
    }
}
