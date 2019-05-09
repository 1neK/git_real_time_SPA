<?php

namespace App\Http\Controllers;

use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
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

    public function index(){
        $user =auth()->user()->id;
        return[
            'read'   =>[],
            'unread' =>Notification::where('user_id',$user)->whereNull('read_at')->get()
        ];
    }

    public function markAsRead(Request $request){
     return   Notification::where('id',$request->id)->update(['read_at'=> Carbon::now()]);
    }
}
