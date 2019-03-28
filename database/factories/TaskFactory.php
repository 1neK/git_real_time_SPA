<?php

use Faker\Generator as Faker;
use App\Model\Project;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name'    =>$name,
        'slug'    =>str_slug($name),
        'project_id' => function(){
            return Project::all()->random();
        },
        'user_id' => function(){
            return App\User::all()->random();
        },
        'type'   => $faker->text,
        'start_date' => $faker->date,
        'due_date' => $faker->date,
        'link' => $faker->text,
        'description' => $faker->text,
        'status' => $faker->text,
    ];
});
