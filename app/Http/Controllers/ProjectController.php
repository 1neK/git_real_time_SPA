<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Project;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;
use App\Task;

class ProjectController extends Controller
{

       /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index','show','count_task','affiche_task']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectResource::collection(Project::latest()->get());
    }

    public  function count_task()
    {

        $projects = Project::all();

        foreach ($projects as $project)
        {
             $count =Task::where('project_id',$project->id)->count();
             $project->task_number=$count;
             /*$task =Task::where('project_id',$project->id)->count();
             $project->task_number=$task;*/

        }

return response()->json($projects);

    }

    public function affiche_task(){
        $projects=Project::all();
        foreach($projects as $project)
        {
            $task =Task::where('project_id',$project->id)->get();
            $project->task_list = $task;
        }
        return response()->json($projects);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request )
    {
      //  $request['slug'] = str_slug($request->title);
      $project =  auth()->user()->project()->create($request->all());

       return response(new ProjectResource($project),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return response('Update', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}

