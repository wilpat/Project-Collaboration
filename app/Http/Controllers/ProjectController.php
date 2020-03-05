<?php

namespace App\Http\Controllers;

use App\Project;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{   

    /**
     * Validate the request attributes
     *
     * @return array
     */
    protected function validateProject(){

        return request()->validate([
            'title' => 'sometimes|required | min:3 | max:255',
            'description' => 'sometimes|required | min:3 | max:100',
            'notes' => 'nullable',
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->id());
        // $projects = Project::all();
        $projects = auth()->user()->accessibleProjects();
        // dd($projects);
        return $projects;
        // return view('projects.index', compact('projects'));
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
        $project = auth()->user()->projects()->create($attributes);
        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        $this->authorize('update', $project);
        return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the project
     *
     * @param  \App\Requests\UpdateProjectRequest  $request - Form request
     * @param  Project                             $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {   
        // $this->authorize('update', $project); // This is a policy
        /*if(auth()->user()->isNot($project->user)){
            abort(403);
        }*/
        // dd(request()->all());
        // $attributes = request(['notes']);
        // $attributes = $this->validateProject();

        // Now validation is done with the UpdateProjectRequest form request class
        // $attributes = $request->validated();
        // $project->update($attributes);

        // Now the update happens with the save method of the UpdateProjectRequest form request handler
        $request->save();

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
        $this->authorize('manage', $project); // A Policy
        $project->delete();
        return redirect('/projects');
    }
}
