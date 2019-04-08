<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Model\Project;

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
        return Task::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {
       $task= $project->replies()->create($request->all());
       $user = $project->user;
       if($task->user_id !== $project->user_id){
        $user->notify(new NewTaskNotification($task));
       }

       return response (['task'=>new TaskResource($task)],Response::HTTP_CREATED);
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
