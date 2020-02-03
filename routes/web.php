<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::resource('tasks', 'TaskController');
Route::get('/tasks', 'TaskController@index');
Route::get('/list/tick', 'TaskController@tickTasks');
Route::delete('/tasks/{task}', 'TaskController@destroy');
Route::put('/tasks/{task}', 'TaskController@update');
Route::post('/tasks/{task}', 'TaskController@store');
