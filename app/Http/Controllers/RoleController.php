<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleRequest;
use App\Role;
use App\User;
use App\Task;


class RoleController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index','show','count_team','affiche']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::collection(Role::latest()->get());
    }

    public  function count_team()
    {

        $teams = Role::all();

        foreach ($teams as $team)
        {
             $count =User::where('role_id',$team->id)->count();
             $team->user_number=$count;
             $task =Task::where('role_id',$team->id)->count();
             $team->task_number=$task;

        }


return response()->json($teams);

    }

    public function affiche(){
        $teams=Role::all();
        foreach($teams as $team)
        {
            $user =User::where('role_id',$team->id)->get();
            $team->user_list = $user;
        }
        return response()->json($teams);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        // Category::create($request->all());
       $role  = new Role();
       $role->name  = $request->name;
       $role->slug  = str_slug($request->name);
       $role->save();
       return response(new RoleResource($role),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($team)
    {

        $role=  Role::where('slug',$team)->first();

        $user =User::where('role_id',$role->id)->get();
        $role->users = $user;


        return response()->json($role);



    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update(['name'=>$request->name,
        'slug'=>str_slug($request->name)]);
        return response(new RoleResource($role), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function all_users()

    {
        $users =User::all();
        foreach ($users as $user)
        {
            $role=Role::find($user->role_id);
            if(!empty($role)){

                $user->roles=$role->name;
            }else{
                $user->roles="undifined";

            }


        }

        return response()->json($users)  ;
    }
}
