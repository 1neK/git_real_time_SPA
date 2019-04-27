<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;

class Task extends Model
{
    public function project(){
        return $this->belongsTo(App\Project::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
