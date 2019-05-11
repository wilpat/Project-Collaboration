<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{   

    // Helpers
    protected function validateProject(){

        return request()->validate([
            'title' => 'required | min:3 | max:255',
            'description' => 'required | min:3 | max:100',
            'notes' => 'min:3',
        ]);

    }

    // End Helpers

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->id());
        // $projects = Project::all();
        $projects = auth()->user()->projects;
        // dd($projects);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes = $this->validateProject();
        // dd(auth()->id());
        // $attributes['user_id'] = auth()->id();
        // Project::create($attributes);
        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        if(auth()->user()->isNot($project->user)){
            abort(403);
        }
        return view('projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project)
    {   
        $this->authorize('update', $project);
        /*if(auth()->user()->isNot($project->user)){
            abort(403);
        }*/
        $attributes = $this->validateProject();
        $project->update($attributes);
        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
