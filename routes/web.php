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

Route::get('/', function () {
    return view('welcome');
});

Route::get('sair', ['as' => 'logout', function () {
    return view('welcome');
}]);

Route::group(['prefix' => 'agenda'], function () {
    Route::get('{date?}', ['as' => 'diary.index', 'uses' => 'DiaryController@index']);
    Route::post('salvar', ['as' => 'diary.store', 'uses' => 'DiaryController@store']);
    Route::post('checkin', ['as' => 'diary.checkin', 'uses' => 'DiaryController@checkin']);
    Route::post('cancelar', ['as' => 'diary.destroy', 'uses' => 'DiaryController@destroy']);
});

Route::group(['prefix' => 'pdv'], function () {
    Route::get('agenda/{id}', ['as' => 'pdv.diary', 'uses' => 'PdvController@index']);
});

Route::group(['prefix' => 'proprietario'], function () {
    Route::get('meus-pets/{id}', ['as' => 'owner.myPets', 'uses' => 'OwnerController@myPets']);
});

Route::group(['prefix' => 'client'], function () {
    Route::get('localizar-por-nome/{name}', ['as' => 'client.findByName', 'uses' => 'ClientController@findByName']);
});

Route::group(['prefix' => 'service'], function () {
    Route::get('localizar-por-raca/{id}', ['as' => 'service.findByBreed', 'uses' => 'ServiceController@findByBreed']);
    Route::get('veterinario', ['as' => 'service.allVet', 'uses' => 'ServiceController@allVet']);
});

Route::get('/info', function () {
    dd(phpinfo());
});
