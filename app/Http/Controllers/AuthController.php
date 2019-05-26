<?php

namespace App\Http\Controllers;

use App\Notifications\TelegramNotification;
use App\Role;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        /* that s validate your data in server */


        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        /* end validation */

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }
        $credentials['status'] = 'Active';
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->respondWithToken($token);
    }

    public function signup(SignupRequest $request)
    {
        $credentials = $request->only('name', 'email', 'password');


        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($credentials, $rules);

        User::create($credentials);
        return $this->login($credentials);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();

        $admins = User::whereIn('role_id', [1, 2])->get();

        foreach ($admins as $admin) {

            try{
                Notification::send($admin, new TelegramNotification(['text' => $user->name . ' logged in ']));
            }catch( \Exception $e){

            }


        }
        if (!empty($user->role_id)) $user->role = Role::where('id', $user->role_id)->value('name');


        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function profile()
    {
        $user = auth()->user();


        $team=Role::find($user->role_id);
        $user->team = $team->name;

        return $user;


    }

    public function updateprofile(Request $request)
    {

       $user = User::find($request->id);
       $user->name=$request->name;
       $user->email=$request->email;
       if (!empty($request->newpassword))
       {
           $user->password=$request->newpassword;
       }

       $user->save();

        return "profile updated";


    }

}
