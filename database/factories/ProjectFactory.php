<?php

use Faker\Generator as Faker;
use App\Model\Task;

$factory->define(Model::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'name'    =>$name,
        'slug'    =>str_slug($name),
        'user_id' => function(){
            return App\User::all()->random();
        }
    ];
});
