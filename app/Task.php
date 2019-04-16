<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function taskComment(){
        return $this->hasMany(TaskComment::class);
    }
}
