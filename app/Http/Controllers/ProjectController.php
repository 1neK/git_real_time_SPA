<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Model\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Model\Task as AppTask;

class ProjectController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show', 'count_task', 'affiche_task']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $count = Task::where('project_id', $project->id)->count();
            $project->task_number = $count;


            $progress_task=Task::where('project_id',$project->id)->where('status','In progress')->count();
            $project->progress_task=$progress_task;

            $completed_task=Task::where('project_id',$project->id)->where('status','Completed')->count();
            $project->completed_task=$completed_task;

            $pending_task=Task::where('project_id',$project->id)->where('status','Incompleted')->count();
            $project->pending_task=$pending_task;



        }

        return response()->json($projects);
    }

    public function count_task()
    {


    }

    public function affiche_task()
    {
        $projects = Project::all();
        foreach ($projects as $project) {
            $task = Task::where('project_id', $project->id)->get();
            $project->task_list = $task;
        }
        return response()->json($projects);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $request['slug'] = str_slug($request->title);

        $user = JWTAuth::toUser($request->token);
       $project =new Project();
       $project->name=$request->name;
        $project->slug=Str::slug($request->name,'-');
        $project->user_id=$user->id;
       $project->save();

        return response()->json('works' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Project $question
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $project=  Project::where('slug',$slug)->first();

        $tasks =Task::where('project_id',$project->id)->get();
        $project->tasks = $tasks;

        foreach ($tasks as $task){

            $user=User::find($task->user_id);
            if (!empty($user)){

                $task->user=$user->name;
            }

        }




        return response()->json($project);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Project $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project)
    {

        $project =Project::find($project);
        $project->name =$request->name;
        $project->save();
        return response()->json('updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Project $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {
        $project =  Project::find($project);
        $project->delete();
        return response()->json('deleted');

    }
}

