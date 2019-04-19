<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('made_by')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->date('start_date');
            $table->date('due_date');
            $table->text('link');
            $table->text('description');
            $table->enum('status', ['In progress', 'Validated','Incompleted','Completed']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('made_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
