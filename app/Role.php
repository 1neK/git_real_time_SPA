<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use Notifiable;
    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function task(){
        return $this->hasMany(Task::class);
    }

    public function routeNotificationForTelegram()
    {

        return $this->telegram_id;
       // return '-292610400';

    }
}
