<?php

use Faker\Generator as Faker;
use App\Task;

$factory->define(App\TaskComment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'user_id' => function(){
            return App\User::all()->random();
        },
        'task_id' => function(){
            return Task::all()->random();
        }
    ];
});
