<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Category::create($request->all());
       $user  = new User();
       $user->name  = $request->name;
        $user->password = Hash::make($request->password);

       $user->status=$request->status;
       $user->email=$request->email;
       $user->role_id=$request->role_id;

       $user->save();
       return response()->json('saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user  =  User::find($id);
        $user->name  = $request->name;
        if (!empty($request->password)) $user->password = Hash::make($request->password);

        $user->status=$request->status;
        $user->email=$request->email;
        $user->role_id=$request->role_id;

        $user->save();
        return response()->json('saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user  =  User::find($id);
        $user->delete();
        return response()->json("deleted");
    }
}
