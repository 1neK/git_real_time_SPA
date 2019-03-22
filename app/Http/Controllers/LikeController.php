<?php

namespace App\Http\Controllers;

use App\Model\Like;
use Illuminate\Http\Request;
use App\Model\Reply;
use App\Events\likeEvent;

class LikeController extends Controller
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


public function likeIt(Reply $reply)
{
    $reply->like()->create([
        'user_id'=> auth()->id()
    ]);

    broadcast(new likeEvent($reply->id, 1))->toOthers();
}

public function unlikeIt(Reply $reply)
{
    $reply->like()->where('user_id',auth()->id())->first()->delete();

    broadcast(new likeEvent($reply->id, 0))->toOthers();
}
}
