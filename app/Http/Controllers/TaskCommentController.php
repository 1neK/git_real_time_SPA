<?php

namespace App\Http\Controllers;

use App\TaskComment;
use Illuminate\Http\Request;
use App\Http\Resources\TaskCommentResource;
use App\Http\Requests\TaskCommentRequest;
use Symfony\Component\HttpFoundation\Response;

class TaskCommentController extends Controller
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
        return TaskCommentResource::collection(TaskComment::latest()->get());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCommentRequest $request)
    {
        $taskComment =  auth()->user()->taskComment()->create($request->all());

       return response(new TaskCommentRequest($taskComment),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskComment  $taskComment
     * @return \Illuminate\Http\Response
     */
    public function show(TaskComment $taskComment)
    {
        return new TaskCommentResource($taskComment);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskComment  $taskComment
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
     * @param  \App\TaskComment  $taskComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskComment $taskComment)
    {
        $taskComment->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
