<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Model\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {

            $task->project = Project::where('id', $task->project_id)->value('name');
            $task->user = User::where('id', $task->user_id)->value('name');
        }

        return response()->json($tasks);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task->description = ($request->description) ?? '';
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->link = ($request->link) ?? '';
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->type = $request->type;
        $task->status = "In progress";
        $task->save();

        return response()->json("saved");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Task $task)
    {
        return new TaskResource($task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $task)
    {
        $task =  Task::find($task);
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->link = $request->link;
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->type = $request->type;

        $task->save();

        return response()->json("saved");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($task)
    {
        $role =  Task::find($task);
        $role->delete();
        return response()->json('deleted');
    }
}
