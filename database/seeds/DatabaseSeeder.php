<?php

use Illuminate\Database\Seeder;

use App\Model\Category;

use App\Model\Reply;
use App\Model\Like;
use App\Model\Question;
use App\Model\Task;
use App\Model\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class,10)->create();
        factory(Category::class,5)->create();
        factory(Question::class,10)->create();
//        factory(Reply::class,50)->create()->each(function($reply){
//            return $reply->like()->save(factory(Like::class)->make());
//        });



    }
}
