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

Route::get('dashboard', ['as' => 'dashboard.index', function () {
    return view('dashboard.index');
}]);

Route::group(['prefix' => 'agenda'], function () {
    Route::get('{date?}', ['as' => 'diary.index', 'uses' => 'DiaryController@index']);
    Route::post('salvar', ['as' => 'diary.store', 'uses' => 'DiaryController@store']);
    Route::post('checkin', ['as' => 'diary.checkin', 'uses' => 'DiaryController@checkin']);
    Route::post('cancelar', ['as' => 'diary.destroy', 'uses' => 'DiaryController@destroy']);
});

Route::group(['prefix' => 'pdv'], function () {
    Route::get('{id?}', ['as' => 'pdv.index', 'uses' => 'PdvController@index']);
    Route::post('registrar-pagamento', ['as' => 'pdv.registerPayment', 'uses' => 'PdvController@registerPayment']);
    Route::get('nota-fiscal/{id}', ['as' => 'pdv.invoice', 'uses' => 'PdvController@invoice']);
});

Route::group(['prefix' => 'financeiro'], function () {
    Route::group(['prefix' => 'despesas'], function () {
        Route::get('salvar', ['as' => 'outlay.store', 'uses' => 'OutlayController@store']);
        Route::get('buscar-por-dia', ['as' => 'outlay.findByDate', 'uses' => 'OutlayController@findByDate']);
    });

    Route::group(['prefix' => 'receita'], function () {
        Route::get('buscar-por-dia', ['as' => 'sale.findByDate', 'uses' => 'SaleController@findByDate']);
    });

    Route::get('extrato-do-dia', ['as' => 'cashdesk.extractOfDay', 'uses' => 'CashdeskController@extractOfDay']);
});
Route::group(['prefix' => 'caixa'], function () {
    Route::post('abrir', ['as' => 'cashdesk.open', 'uses' => 'CashdeskController@open']);
    Route::post('fechar', ['as' => 'cashdesk.close', 'uses' => 'CashdeskController@close']);
    Route::get('checar-status', ['as' => 'cashdesk.status', 'uses' => 'CashdeskController@status']);
    Route::get('valor-gaveta', ['as' => 'cashdesk.getCashDrawer', 'uses' => 'CashdeskController@getCashDrawer']);
    Route::get('inconsistencia-caixa-nao-finalizado', ['as' => 'cashdesk.inconsistencyUnfinishedCashdesk', 'uses' => 'CashdeskController@inconsistencyUnfinishedCashdesk']);
});

Route::group(['prefix' => 'proprietario'], function () {
    Route::get('meus-pets/{id}', ['as' => 'owner.myPets', 'uses' => 'OwnerController@myPets']);
});

Route::group(['prefix' => 'cliente'], function () {
    Route::get('localizar-por-nome/{name}', ['as' => 'client.findByName', 'uses' => 'ClientController@findByName']);
});

Route::group(['prefix' => 'servico'], function () {
    Route::get('localizar-por-raca/{id}', ['as' => 'service.findByBreed', 'uses' => 'ServiceController@findByBreed']);
    Route::get('veterinario', ['as' => 'service.allVet', 'uses' => 'ServiceController@allVet']);
});

Route::group(['prefix' => 'produto'], function () {
    Route::get('localizar-por-nome/{name}', ['as' => 'product.findByName', 'uses' => 'ProductController@findByName']);
});

Route::group(['prefix' => 'desconto'], function () {
    Route::get('', ['as' => 'rebate.findAll', 'uses' => 'RebateController@findAll']);
});

Route::get('/info', function () {
    dd(phpinfo());
});
