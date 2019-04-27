<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function task(){
        return $this->hasMany(Task::class);
    }
}
