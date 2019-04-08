<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Project extends Model
{
    public function getRouteKeyName()
    {
        return'slug';
    }
    //protected $fillable=['title','slug','user_id'];
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
