<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
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
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Role;

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
        $user = JWTAuth::toUser(Input::get('token'));


        $data = Task::whereNotNull('id');
        foreach ($request->all() as $item => $value) {
            if (!empty($value) && $item != 'token') $data->where($item, $value);

        }

        if ($user->role_id != 1 && $user->role_id != 2) $data->where('user_id', $user->id);


        $tasks = $data->get();
        foreach ($tasks as $task) {

            $task->category = Category::where('id', $task->category_id)->value('name');
            $task->project = Project::where('id', $task->project_id)->value('name');
            $task->user = User::where('id', $task->user_id)->value('name');
            $task->createdBy = User::where('id', $task->made_by)->value('name');
            $task->comments = TaskComment::where('task_id', $task->id)->count();
        }


        return response()->json($tasks);


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $user = auth()->user();
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

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);

        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->first();


        //Notification::send($to, new TelegramNotification(['text' => '@' . $from . ' create new task: ' . $category->name . ', Project: ' . $project->name . 'for @' . $to->name]));

        $group=Role::find($to->role_id);

        $coordinator=Role::find(2);



     //if translator add



        try{

            Notification::send($group, new TelegramNotification(['text' => '@' . $from . ' added a new task: ' . $category->name . ', Project: ' . $project->name . ' for @' . $to->name.' \n Link:  \n'.$task->link]));

            Notification::send($coordinator, new TelegramNotification(['text' => '@' . $from . ' added a new task: ' . $category->name . ', Project: ' . $project->name . ' for @' . $to->name]));
         }catch( \Exception $e){



        }
        $link = env('APP_URL','http://127.0.0.1:8000').'/task/' . $task->id;

        \App\Notification::create([
            'user_id' => $to->id,
            'link' => $link,
            'text' => $from . ' create new task: ' . $category->name . ', Project: ' . $project->name,
        ]);
        event(new CommentEvent($from, $from . ' added a new task', $link));


        return response()->json('task has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show($task)
    {
        $task = Task::find($task);

        $task->category = Category::where('id', $task->category_id)->value('name');
        $task->project = Project::where('id', $task->project_id)->value('name');
        $task->user = User::where('id', $task->user_id)->value('name');
        $task->createdBy = User::where('id', $task->made_by)->value('name');

        $task->comments = $task->taskComment;

        foreach ($task->comments as $comment) {
            $user = User::find($comment->user_id);
            if (!empty($user)) {
                $comment->user = $user->name;
            } else   $comment->user = 'unkown';


        }


        return $task;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task)
    {
        $task = Task::find($task);
        $task->description = ($request->description) ?? '';
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->link = ($request->link) ?? '';
        $task->project_id = $request->project_id;
        $task->start_date = $request->start_date;
        $task->category_id = $request->category_id;

        $task->save();

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);

        $from = auth()->user()->name;
        $to = User::where('id', $task->user_id)->first();

        $group=Role::find($to->role_id);
        $coordinator=Role::find(2);

        try{
            Notification::send($group, new TelegramNotification(['text' => '@' . $from . 'has updated the task: ' . $category->name . ', Project: ' . $project->name . '  for @' . $to->name]));
            Notification::send($coordinator, new TelegramNotification(['text' => '@' . $from . 'has updated the task: ' . $category->name . ', Project: ' . $project->name . ' for @' . $to->name]));
        }catch( \Exception $e){

        }

        //Notification::send($to, new TelegramNotification(['text' => '@' . $from . ' updated the task: ' . $category->name . ', Project: ' . $project->name . ' for @' . $to->name]));

        $link = env('APP_URL','http://127.0.0.1:8000').'/task/' . $task->id;

        \App\Notification::create([
            'user_id' => $to->id,
            'link' => $link,
            'text' => $from . ' updated task: ' . $category->name . ', Project: ' . $project->name
        ]);
        event(new CommentEvent($from, $from . ' updated task', $link));


        return response()->json("task has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Task::where('id', $id)->first();

        $role->delete();
        return response()->json('task has been  deleted');
    }


    public function allyears()
    {

        $years = Task::select(DB::raw('EXTRACT(year from start_date) as year'))->groupBy('year')->pluck('year')->toArray();

        return $years;

    }

    public function start(Request $request)
    {
        $task = Task::find($request->id);
        $task->status = 'In progress';
        $task->save();

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);

        $from = User::where('id', $task->made_by)->value('name');
        $to = User::where('id', $task->user_id)->first();

        $group=Role::find($to->role_id);



        $admins = User::whereIn('role_id', [1, 2])->get();
        $link = env('APP_URL','http://127.0.0.1:8000').'/task/' . $task->id;


            Notification::send($group, new TelegramNotification(['text' => '@' . $to->name . ' started the task:  @' . $category->name . ', Project: ' . $project->name]));

        foreach ($admins as $admin) {
            \App\Notification::create([
                'user_id' => $admin->id,
                'link' => $link,
                'text' => $to->name . ' started the task: ' . $category->name . ', Project: ' . $project->name,
            ]);


        }
        event(new CommentEvent($to, $to . ' started task', $link));


        return response()->json("task has been started");
    }


    public function completed(Request $request)
    {

        $task = Task::find($request->id);
        $task->status = 'Completed';
        $task->final_link = ($request->link) ?? '';;
        $task->save();

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);

        $to = User::where('id', $task->user_id)->first();

        $link = env('APP_URL','http://127.0.0.1:8000').'/tasks';
        $group=Role::find($to->role_id);

        $admins = User::whereIn('role_id', [1, 2])->get();



            Notification::send($group, new TelegramNotification(['text' => '@' . $to->name . ' completed the task: ' . $category->name . ', Project: ' . $project->name.' Link: '.$task->final_link]));
foreach ($admins as $admin) {
            \App\Notification::create([
                'user_id' => $admin->id,
                'link' => $link,
                'text' => $to->name . ' completed the task: ' . $category->name . ', Project: ' . $project->name,
            ]);

        }


        event(new CommentEvent($to, $to . ' completed task', $link));

        return response()->json("task has been completed");
    }

    public function accept(Request $request)
    {
        $task = Task::find($request->id);
        $task->status = 'Validated';
        $task->date_completed = now();
        $task->save();

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);

        $user = auth()->user()->name;
        $to = User::where('id', $task->user_id)->first();
        $group=Role::find($to->role_id);
        $link = env('APP_URL','http://127.0.0.1:8000').'/task/' . $task->id;

        Notification::send($group, new TelegramNotification(['text' => '@' . $user . ' accpted the task:  @' . $category->name . ', Project: ' . $project->name]));

        \App\Notification::create([
            'user_id' => $to->id,
            'link' => $link,
            'text' => $user . ' accepted the task: ' . $category->name . ', Project: ' . $project->name,
        ]);


        event(new CommentEvent($user, $user . ' accepted task', $link));


        return response()->json("task has been accepted");
    }

    public function reject(Request $request)
    {
        $task = Task::find($request->id);
        $task->status = 'In progress';
        $task->final_link = null;

        $task->save();

        $category = Category::find($task->category_id);
        $project = Project::find($task->project_id);


        $user = auth()->user()->name;
        $to = User::where('id', $task->user_id)->first();
        $group=Role::find($to->role_id);
        $link = env('APP_URL','http://127.0.0.1:8000').'/task/' . $task->id;

        Notification::send($group, new TelegramNotification(['text' => '@' . $user . ' rejected the task:  @' . $category->name . ', Project: ' . $project->name]));

        \App\Notification::create([
            'user_id' => $to->id,
            'link' => $link,
            'text' => $user . ' rejected the task: ' . $category->name . ', Project: ' . $project->name,
        ]);


        event(new CommentEvent($user, $user . ' rejected  ', $link));


        return response()->json("task has been rejected");
    }


}
