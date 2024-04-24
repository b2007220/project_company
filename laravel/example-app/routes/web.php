<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});
Route::get('role', [
    'middleware' => 'Role:editor',
    'uses' => 'TestController@index',
]);
Route::get('user/{name?}', function ($name = 'TutorialsPoint') {
    return $name;
});
Route::get('/usercontroller/path',[
    'middleware' => 'First',
    'uses' => 'UserController@showPath'
 ]);