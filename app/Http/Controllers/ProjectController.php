<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Project;

class ProjectController extends Controller
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
        return Project::latest()->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $question)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Project  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $question)
    {

    }
}
