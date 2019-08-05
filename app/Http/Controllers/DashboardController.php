<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\TaskComment;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }


    public function index(Request $request)
    {

        $user = JWTAuth::toUser(Input::get('token'));


        $data = Task::whereNotNull('id');

        if (!empty($request->user_id)) $data->where('user_id', $request->user_id);
        if (!empty($request->project_id)) $data->where('project_id', $request->project_id);
        if (!empty($request->year)) $data->whereYear('start_date', $request->year);
        if (!empty($request->month)) $data->whereMonth('start_date', $request->month);
        if (!empty($request->status)) $data->where('status', $request->status);


        if ($user->role_id != 1 && $user->role_id != 2)  $data->where('user_id',$user->id);



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

    public function stats()
    {

        $user =auth()->user();
        if($user->role_id ==1 OR $user->role_id ==2 ){
            $validated=Task::where('status','Validated')->count();
            $completed=Task::where('status','Completed')->count();
            $all=Task::count();
        }else{

            $validated=Task::where('status','Validated')->where('user_id',$user->id)->count();
            $completed=Task::where('status','Completed')->where('user_id',$user->id)->count();
            $all=Task::where('user_id',$user->id)->count();
        }

        $prod= ($all >0 ) ? ($validated/$all)*100 : '0';
        $prod=round($prod,2);


        return array('validated'=>$validated,'completed'=>$completed,'prod'=>$prod, 'all'=>$all);




    }
}
