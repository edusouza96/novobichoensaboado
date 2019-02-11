<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('sair', ['as' => 'logout', function () {
    return view('welcome');
}]);

Route::group(['prefix' => 'agenda'], function () {
    Route::get('{date?}', ['as' => 'diary.index', 'uses' => 'DiaryController@index']);
});

Route::group(['prefix' => 'client'], function () {
    Route::get('localizar-por-nome/{name}', ['as' => 'client.findByName', 'uses' => 'ClientController@findByName']);
});

Route::group(['prefix' => 'service'], function () {
    Route::get('localizar-por-raca/{id}', ['as' => 'service.findByBreed', 'uses' => 'ServiceController@findByBreed']);
});