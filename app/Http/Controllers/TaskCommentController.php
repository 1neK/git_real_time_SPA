<?php

namespace App\Http\Controllers;

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


        $admins = User::whereIn('role_id', [1, 2])->get();

        foreach ($admins as $admin) {

            if ($admin->id != $user->id) Notification::send($admin, new TelegramNotification(['text' => '@' . $user->name . ' commented on task  @' . $task_commment->task_id . ' :' . $task_commment->body]));
        }


        if ($to->id != $user->id) Notification::send($to, new TelegramNotification(['text' => '@' . $user->name . ' commented on task  @' . $task_commment->task_id . ' :' . $task_commment->body]));


        return response()->json("inserted");
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
    public function update(Request $request, TaskComment $taskComment)
    {
        $taskComment->update($request->all());
        return response('Update', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TaskComment $taskComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskComment $taskComment)
    {
        $taskComment->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
