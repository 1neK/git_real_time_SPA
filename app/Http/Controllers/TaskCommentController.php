<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Http\Resources\TaskCommentResource;
use App\Model\Task;
use App\Notifications\TelegramNotification;
use App\TaskComment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Model\Category;
use App\Model\Project;

class TaskCommentController extends Controller
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
        return TaskCommentResource::collection(TaskComment::latest()->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $task_id)
    {
        $user = JWTAuth::toUser(Input::get('token'));

        $task_commment = new TaskComment();
        $task_commment->task_id = $task_id;
        $task_commment->body = $request->body;
        $task_commment->user_id = $user->id;
        $task_commment->save();


        $task = Task::find($task_id);

        $to = User::where('id', $task->user_id)->first();

        $category= Category::find($task->category_id);
        $project= Project::find($task->project_id);
        $admins = User::whereIn('role_id', [1, 2])->get();
        $link='http://127.0.0.1:8000/task/'.$task_id;
        foreach ($admins as $admin) {

            if ($admin->id != $user->id) {
                Notification::send($admin, new TelegramNotification(['text' => '@' . $user->name . ' commented on task: ' .$category->name.', Project: '.$project->name . ' :' . $task_commment->body]));
                \App\Notification::create([
                    'user_id' => $admin->id,
                    'link' => $link,
                    'text' => $user->name . ' commented on task: '.$category->name.', Project: '.$project->name,

                ]);
                }

        }


        if ($to->id != $user->id)
        {
            Notification::send($to, new TelegramNotification(['text' => '@' . $user->name . ' commented on task: '.$category->name.', Project: '.$project->name . ' :' . $task_commment->body]));
            \App\Notification::create([

                'user_id' => $to->id,
                'link' => $link,
                'text' => $user->name.' commented on task: '.$category->name.', Project: '.$project->name,


            ]);
        }







     event(new CommentEvent($user->name,$task_commment->body,$link ));



        return response()->json("saved");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TaskComment $taskComment
     * @return \Illuminate\Http\Response
     */
    public function show(TaskComment $taskComment)
    {
        return new TaskCommentResource($taskComment);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\TaskComment $taskComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $taskComment)
    {
        $comment =TaskComment::find($taskComment);
        $comment->body=$request->body;
        $comment->save();


        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TaskComment $taskComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskComment)
    {
        TaskComment::find($taskComment)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
