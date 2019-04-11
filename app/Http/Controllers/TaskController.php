<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Model\Project;
use App\User;

class TaskController extends Controller
{
/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks= Task::all();

        foreach($tasks as $task){

            $task->project =Project::where('id',$task->project_id)->pluck('name')[0];
            $task->user =User::where('id',$task->project_id)->pluck('name')[0];
        }

return response()->json($tasks);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $task= new Task();
     $task->description=$request->description;
     $task->due_date=$request->due_date;
     $task->user_id=$request->user_id;
     $task->link=$request->link;
     $task->project_id =$request->project_id;
     $task->start_date =$request->start_date;
     $task->type=$request->type;
     $task->status="In progress";
     $task->save();

       return response ()->json("saved");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project,Task $task)
    {
        return new TaskResource($task);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question,Request $request, Reply $reply)
    {
        $reply->update($request->all());
        return response('Updated',Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,Task $task)
    {
    $task->delete();
    broadcast(new DeleteTaskEvent($task->id))->toOthers();
    return response(null,Response::HTTP_NO_CONTENT);
    }
}
