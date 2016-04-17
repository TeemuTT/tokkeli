<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::resource('project', 'ProjectController');
    
    Route::resource('timesheet', 'TimesheetController', ['only' => ['store', 'edit', 'update', 'destroy']]);
    
    Route::resource('user', 'UserController', ['only' => ['index', 'edit', 'update', 'destroy']]);
    
    Route::get('/project/{id}/invite', ['uses' => 'ProjectController@showInvite']);
    
    Route::post('/project/{id}/invite', ['uses' => 'ProjectController@invite']);
    
    Route::get('/project/{id}/leave', ['uses' => 'ProjectController@leave']);
});


Route::get('/api/project/{id}', ['as' => 'publicproject', 'uses' => 'ApiController@show']);
