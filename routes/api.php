<?php

Route::apiResource('/question','QuestionController');

Route::apiResource('/category','CategoryController');


Route::apiResource('/user','UserController');

Route::apiResource('/team','RoleController');
Route::get('/count-team','RoleController@count_team');
Route::get('/liste-team','RoleController@affiche');

Route::apiResource('/question/{question}/reply','ReplyController');

Route::post('/like/{reply}','LikeController@likeIt');
Route::delete('/like/{reply}','LikeController@unLikeIt');

Route::post('notifications', 'NotificationController@index');
Route::post('markAsRead', 'NotificationController@markAsRead');

Route::apiResource('/project','ProjectController');

Route::post('/task/{taskcomment}','TaskCommentController@store');
Route::delete('/task/{taskcomment}','TaskCommentController@destroy');
Route::patch('/task/{taskcomment}','TaskCommentController@update');
//Route::get('/task/{taskcomment}','TaskComment@index');
Route::apiResource('/task','TaskController');
Route::get('/count-task','RoleController@count_task');
Route::get('/liste-task','RoleController@affiche_task');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
