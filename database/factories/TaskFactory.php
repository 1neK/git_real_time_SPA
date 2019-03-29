<?php

use Faker\Generator as Faker;
use App\Model\Project;

$factory->define(Model::class, function (Faker $faker) {
    $name = $faker->sentence;
    $type = $faker->word;
    $status = $faker->word;
    return [
        'name'    =>$name,
        'slug'    =>str_slug($name),
        'user_id' => function(){
            return App\User::all()->random();
        },
        'type'   => $type,
        'start_date' => $faker->date,
        'due_date' => $faker->date,
        'link' => $faker->text,
        'description' => $faker->text,
        'status' => $status,
    ];
});
