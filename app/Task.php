<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function task_comment(){
        return $this->hasMany(TaskComment::class);
    }
}
