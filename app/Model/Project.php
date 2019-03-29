<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
    public function task (){
        return $this-> hasMany(Task::class);
    }

    public function user(){
        return $this-> belongsTo(User::class);
    }
}
