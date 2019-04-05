<?php

Route::apiResource('/question','QuestionController');

Route::apiResource('/category','CategoryController');

Route::apiResource('/team','RoleController');
Route::get('/count-team','RoleController@count_team');
Route::get('/liste-team','RoleController@affiche');

Route::apiResource('/question/{question}/reply','ReplyController');

Route::post('/like/{reply}','LikeController@likeIt');
Route::delete('/like/{reply}','LikeController@unLikeIt');

Route::post('notifications', 'NotificationController@index');
Route::post('markAsRead', 'NotificationController@markAsRead');

Route::apiResource('/project','ProjectController');
Route::apiResource('/task','TaskController');

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
