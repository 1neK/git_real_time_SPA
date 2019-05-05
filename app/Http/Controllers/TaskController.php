<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Project;
use App\Notifications\TelegramNotification;
use App\Task;
use App\TaskComment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = JWTAuth::toUser( Input::get('token') );


         $data =Task::whereNotNull('id');
         foreach ($request->all() as $item => $value)
         {
             if (!empty($value) && $item!='token') $data->where($item,$value);

         }

        if ($user->role_id != 1 && $user->role_id != 2)  $data->where('user_id',$user->id);


         $tasks=$data->get();
            foreach ($tasks as $task) {

                $task->category = Category::where('id', $task->category_id)->value('name');
                $task->project = Project::where('id', $task->project_id)->value('name');
                $task->user = User::where('id', $task->user_id)->value('name');
                $task->createdBy = User::where('id', $task->made_by)->value('name');
                $task->comments=TaskComment::where('task_id',$task->id)->count();
            }


            return response()->json($tasks);








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

        $user = JWTAuth::toUser($request->token);
        $task = new Task();
        $task->description = ($request->description) ?? '';
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->made_by = $user->id;
        $task->link = ($request->link) ?? '';
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->category_id = $request->category_id;
        $task->status = "Incompleted";
        $task->save();


        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->value('name');



        Notification::send( new User(),new TelegramNotification( ['text' => '@'.$from.' create new task for @'.$to]));


        return response()->json("saved");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show($task)
    {
        $task =Task::find($task);

        $task->category = Category::where('id', $task->category_id)->value('name');
        $task->project = Project::where('id', $task->project_id)->value('name');
        $task->user = User::where('id', $task->user_id)->value('name');
        $task->createdBy = User::where('id', $task->made_by)->value('name');

        $task->comments =$task->taskComment;

        foreach ( $task->comments  as $comment)
        {
            $comment->user=User::find($comment->user_id)->value('name');

        }


        return $task;

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
        $task->description = ($request->description) ?? '';
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->link = ($request->link) ?? '';
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->category_id = $request->category_id;

        $task->save();

        return response()->json("saved");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $role =  Task::where('id',$id)->first();

        $role->delete();
        return response()->json('deleted');
    }


    public function allyears()
    {

        $years=Task::select(DB::raw('EXTRACT(year from start_date) as year'))->groupBy('year')->pluck('year')->toArray();

        return $years;

    }

    public function start(Request $request)
    {
        $task=Task::find($request->id);
       $task->status='In progress';

        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->value('name');



        Notification::send( new User(),new TelegramNotification( ['text' => '@'.$to.' started the task  @'.$task->id]));



       $task->save();

            return response()->json("saved");
    }


    public function completed(Request $request)
    {
        $task=Task::find($request->id);
        $task->status='Completed';
        $task->final_link=$request->link;


        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->value('name');



        Notification::send( new User(),new TelegramNotification( ['text' => '@'.$to.' completed the task  @'.$task->id]));

        $task->save();

        return response()->json("saved");
    }
    public function accept(Request $request)
    {
        $task=Task::find($request->id);
        $task->status='Validated';
        $task->date_completed=now();


        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->value('name');



        Notification::send( new User(),new TelegramNotification( ['text' => '@'.$from.' accpted the task  @'.$task->id]));


        $task->save();

        return response()->json("saved");
    }
    public function reject(Request $request)
    {
        $task=Task::find($request->id);
        $task->status='In progress';
        $task->final_link=null;


        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->value('name');



        Notification::send( new User(),new TelegramNotification( ['text' => '@'.$from.' rejected the task  @'.$task->id]));

        $task->save();

        return response()->json("saved");
    }


}
