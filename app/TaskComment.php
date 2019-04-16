<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
