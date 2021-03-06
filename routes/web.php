<?php

use Illuminate\Support\Facades\Log;
use BichoEnsaboado\Http\Middleware\CashdeskStatus;

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
Route::get('/info', function () { phpinfo(); });

Route::get('/', function () { return redirect(route('dashboard.index')); });

Auth::routes(['register' => false]);

Route::get('sair', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);

Route::group(['middleware' => 'auth'], function() {
    
    Route::get('selecionar-loja', ['as' => 'auth-definition.selectCurrenteStore', 'uses' => 'Auth\DefinitionController@selectCurrenteStore']);
    Route::post('selecionar-loja/store', ['as' => 'auth-definition.setCurrenteStore', 'uses' => 'Auth\DefinitionController@setCurrenteStore']);

    Route::group(['middleware' => 'check_store_user'], function() {
    
        Route::get('dashboard', ['as' => 'dashboard.index', function () {
            return view('dashboard.index');
        }]);

        Route::post('acesso-admin', ['as' => 'user.acessAdmin', 'uses' => 'UserController@acessAdmin']);

        Route::group(['prefix' => 'agenda'], function () {
            Route::get('{date?}/{msg?}', ['as' => 'diary.index', 'uses' => 'DiaryController@index']);
            Route::post('salvar', ['as' => 'diary.store', 'uses' => 'DiaryController@store']);
            Route::post('checkin', ['as' => 'diary.checkin', 'uses' => 'DiaryController@checkin']);
            Route::post('cancelar', ['as' => 'diary.destroy', 'uses' => 'DiaryController@destroy']);
        });

        Route::group(['prefix' => 'vendas'], function () {
            Route::get('estorno', ['as' => 'sales.chargeback', 'uses' => 'SaleController@chargeback']);
            Route::get('do-dia/{date?}', ['as' => 'sales.ofDay', 'uses' => 'SaleController@ofDay']);
            Route::get('itens-por-venda/{id}', ['as' => 'sales.itemsBySale', 'uses' => 'SaleController@itemsBySale']);
        });

        Route::group(['prefix' => 'pdv'], function () {
            Route::get('{id?}', ['as' => 'pdv.index', 'uses' => 'PdvController@index'])->middleware(CashdeskStatus::class);
            Route::post('registrar-pagamento', ['as' => 'pdv.registerPayment', 'uses' => 'PdvController@registerPayment']);
            Route::get('nota-fiscal/{id}', ['as' => 'pdv.invoice', 'uses' => 'PdvController@invoice']);
            Route::get('compras/{ids}', ['as' => 'pdv.getBuys', 'uses' => 'PdvController@getBuys']);
        });

        Route::group(['prefix' => 'fonte'], function () {
            Route::get('buscar-por-loja/{id}', ['as' => 'treasure.findByStore', 'uses' => 'TreasureController@findByStore']);
            Route::get('lista-maquinas-cartoes/{id}', ['as' => 'treasure.findOptionsCardMachineByStore', 'uses' => 'TreasureController@findOptionsCardMachineByStore']);
        });

        Route::group(['prefix' => 'financeiro'], function () {
            Route::group(['prefix' => 'despesas'], function () {
                Route::get('/', ['as' => 'outlay.index', 'uses' => 'OutlayController@index']);
                Route::post('cadastrar', ['as' => 'outlay.store', 'uses' => 'OutlayController@store']);
                Route::get('cadastrar', ['as' => 'outlay.create', 'uses' => 'OutlayController@create']);
                Route::get('editar/{id}', ['as' => 'outlay.edit', 'uses' => 'OutlayController@edit']);
                Route::post('editar/{id}', ['as' => 'outlay.update', 'uses' => 'OutlayController@update']);
                Route::get('deletar/{id}', ['as' => 'outlay.destroy', 'uses' => 'OutlayController@destroy']);
                Route::get('buscar/{id}', ['as' => 'outlay.showJson', 'uses' => 'OutlayController@showJson']);
                Route::post('pagar', ['as' => 'outlay.pay', 'uses' => 'OutlayController@pay']);
                Route::get('lista/{type}', ['as' => 'outlay.listDashboard', 'uses' => 'OutlayController@listDashboard']);
                Route::get('deletar/{type}', ['as' => 'outlay.destroy', 'uses' => 'OutlayController@destroy']);
                Route::get('buscar-por-dia', ['as' => 'outlay.findByDate', 'uses' => 'OutlayController@findByDate']);
            });

            Route::group(['prefix' => 'receita'], function () {
                Route::get('buscar-por-dia', ['as' => 'sale.findByDate', 'uses' => 'SaleController@findByDate']);
            });

            Route::get('extrato-do-dia', ['as' => 'cashdesk.extractOfDay', 'uses' => 'CashdeskController@extractOfDay']);
            Route::post('transferencia', ['as' => 'cashdesk.moneyTransfer', 'uses' => 'CashdeskController@moneyTransfer']);
            Route::get('blacklist', ['as' => 'cashdesk.blacklist', 'uses' => 'DiaryController@blacklist']);
        });
        Route::group(['prefix' => 'caixa'], function () {
            Route::post('aporte', ['as' => 'cashdesk.contribute', 'uses' => 'CashdeskController@contribute']);
            Route::post('sangria', ['as' => 'cashdesk.bleed', 'uses' => 'CashdeskController@bleed']);
            Route::post('abrir', ['as' => 'cashdesk.open', 'uses' => 'CashdeskController@open']);
            Route::post('fechar', ['as' => 'cashdesk.close', 'uses' => 'CashdeskController@close']);
            Route::get('checar-status', ['as' => 'cashdesk.status', 'uses' => 'CashdeskController@status']);
            Route::get('valor-gaveta', ['as' => 'cashdesk.getCashDrawer', 'uses' => 'CashdeskController@getCashDrawer']);
            Route::get('inconsistencia-caixa-nao-finalizado', ['as' => 'cashdesk.inconsistencyUnfinishedCashdesk', 'uses' => 'CashdeskController@inconsistencyUnfinishedCashdesk']);
        });

        Route::group(['prefix' => 'proprietario'], function () {
            Route::get('', ['as' => 'owner.index', 'uses' => 'OwnerController@index']);
            Route::get('meus-pets/{id}', ['as' => 'owner.myPets', 'uses' => 'OwnerController@myPets']);
            Route::get('cadastrar', ['as' => 'owner.create', 'uses' => 'OwnerController@create']);
            Route::post('cadastrar', ['as' => 'owner.store', 'uses' => 'OwnerController@store']);
            Route::get('editar/{id}', ['as' => 'owner.edit', 'uses' => 'OwnerController@edit']);
            Route::post('editar/{id}', ['as' => 'owner.update', 'uses' => 'OwnerController@update']);
            Route::get('deletar/{id}', ['as' => 'owner.destroy', 'uses' => 'OwnerController@destroy']);
        });

        Route::group(['prefix' => 'pet'], function () {
            Route::get('localizar-por-nome/{name}', ['as' => 'client.findByName', 'uses' => 'ClientController@findByName']);
            Route::get('deletar/{id}', ['as' => 'client.destroy', 'uses' => 'ClientController@destroy']);
            Route::get('cadastrar/{id}', ['as' => 'client.create', 'uses' => 'ClientController@create']);
            Route::post('cadastrar', ['as' => 'client.store', 'uses' => 'ClientController@store']);
            Route::get('editar/{id}', ['as' => 'client.edit', 'uses' => 'ClientController@edit']);
            Route::post('editar/{id}', ['as' => 'client.update', 'uses' => 'ClientController@update']);
            Route::get('historico/{client_id}', ['as' => 'client.historic', 'uses' => 'DiaryController@historic']);
        });

        Route::group(['prefix' => 'servico'], function () {
            Route::get('localizar-por-raca/{id}', ['as' => 'service.findByBreed', 'uses' => 'ServiceController@findByBreed']);
            Route::get('veterinario', ['as' => 'service.allVet', 'uses' => 'ServiceController@allVet']);
            Route::get('', ['as' => 'service.index', 'uses' => 'ServiceController@index']);
            Route::get('deletar/{id}', ['as' => 'service.destroy', 'uses' => 'ServiceController@destroy']);
            Route::get('cadastrar', ['as' => 'service.create', 'uses' => 'ServiceController@create']);
            Route::post('cadastrar', ['as' => 'service.store', 'uses' => 'ServiceController@store']);
            Route::get('editar/{id}', ['as' => 'service.edit', 'uses' => 'ServiceController@edit']);
            Route::post('editar/{id}', ['as' => 'service.update', 'uses' => 'ServiceController@update']);
        });

        Route::group(['prefix' => 'produto'], function () {
            Route::get('localizar-por-nome/{name}', ['as' => 'product.findByName', 'uses' => 'ProductController@findByName']);
            Route::get('aviso-baixa-quantidade', ['as' => 'product.lowQuantity', 'uses' => 'ProductController@lowQuantity']);
            Route::get('', ['as' => 'product.index', 'uses' => 'ProductController@index']);
            Route::get('deletar/{id}', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);
            Route::get('cadastrar', ['as' => 'product.create', 'uses' => 'ProductController@create']);
            Route::post('cadastrar', ['as' => 'product.store', 'uses' => 'ProductController@store']);
            Route::get('editar/{id}', ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
            Route::post('editar/{id}', ['as' => 'product.update', 'uses' => 'ProductController@update']);
            Route::get('codigo-barras/{id}/{count?}', ['as' => 'product.barcode', 'uses' => 'ProductController@barcode']);
        });

        Route::group(['prefix' => 'bairro'], function(){
            Route::get('', ['as' => 'neighborhood.index', 'uses' => 'NeighborhoodController@index']);
            Route::get('cadastrar', ['as' => 'neighborhood.create', 'uses' => 'NeighborhoodController@create']);
            Route::get('editar/{id}', ['as' => 'neighborhood.edit', 'uses' => 'NeighborhoodController@edit']);
            Route::get('deletar/{id}', ['as' => 'neighborhood.destroy', 'uses' => 'NeighborhoodController@destroy']);
            Route::post('cadastrar', ['as' => 'neighborhood.store', 'uses' => 'NeighborhoodController@store']);
            Route::post('editar/{id}', ['as' => 'neighborhood.update', 'uses' => 'NeighborhoodController@update']);
            Route::get('opcoes', ['as' => 'neighborhood.allOptions', 'uses' => 'NeighborhoodController@allOptions']);
        });

        Route::group(['prefix' => 'racas'], function(){
            Route::get('', ['as' => 'breed.index', 'uses' => 'BreedController@index']);
            Route::get('cadastrar', ['as' => 'breed.create', 'uses' => 'BreedController@create']);
            Route::get('editar/{id}', ['as' => 'breed.edit', 'uses' => 'BreedController@edit']);
            Route::get('deletar/{id}', ['as' => 'breed.destroy', 'uses' => 'BreedController@destroy']);
            Route::post('cadastrar', ['as' => 'breed.store', 'uses' => 'BreedController@store']);
            Route::post('editar/{id}', ['as' => 'breed.update', 'uses' => 'BreedController@update']);
            Route::get('opcoes', ['as' => 'breed.allOptions', 'uses' => 'BreedController@allOptions']);
        });

        Route::group(['prefix' => 'centro-custo'], function(){
            Route::group(['middleware' => ['role:admin|developer']], function(){
                Route::get('', ['as' => 'costCenter.index', 'uses' => 'CostCenterController@index']);
                Route::get('cadastrar', ['as' => 'costCenter.create', 'uses' => 'CostCenterController@create']);
                Route::get('editar/{id}', ['as' => 'costCenter.edit', 'uses' => 'CostCenterController@edit']);
                Route::get('deletar/{id}', ['as' => 'costCenter.destroy', 'uses' => 'CostCenterController@destroy']);
                Route::post('cadastrar', ['as' => 'costCenter.store', 'uses' => 'CostCenterController@store']);
                Route::post('editar/{id}', ['as' => 'costCenter.update', 'uses' => 'CostCenterController@update']);
            });

            Route::get('opcoes', ['as' => 'costCenter.allOptions', 'uses' => 'CostCenterController@allOptions']);

            Route::group(['prefix' => 'categoria'], function(){
                Route::get('opcoes', ['as' => 'costCenter.category.allOptions', 'uses' => 'CostCenterCategoryController@allOptions']);
            });
        });

        Route::group(['prefix' => 'promocao'], function(){
            Route::get('todos-ativos', ['as' => 'rebate.findActive', 'uses' => 'RebateController@findActive']);
            Route::get('', ['as' => 'rebate.index', 'uses' => 'RebateController@index']);
            Route::get('cadastrar', ['as' => 'rebate.create', 'uses' => 'RebateController@create']);
            Route::get('editar/{id}', ['as' => 'rebate.edit', 'uses' => 'RebateController@edit']);
            Route::post('cadastrar', ['as' => 'rebate.store', 'uses' => 'RebateController@store']);
            Route::post('editar/{id}', ['as' => 'rebate.update', 'uses' => 'RebateController@update']);
            Route::get('ativar/{id}', ['as' => 'rebate.active', 'uses' => 'RebateController@active']);
            Route::get('inativar/{id}', ['as' => 'rebate.inactive', 'uses' => 'RebateController@inactive']);
        });

        Route::group(['prefix' => 'loja'], function(){
            Route::group(['middleware' => ['role:admin|developer']], function(){
                Route::get('cadastrar', ['as' => 'store.create', 'uses' => 'StoreController@create']);
                Route::post('cadastrar', ['as' => 'store.store', 'uses' => 'StoreController@store']);
                Route::get('editar/{id}', ['as' => 'store.edit', 'uses' => 'StoreController@edit']);
                Route::post('editar/{id}', ['as' => 'store.update', 'uses' => 'StoreController@update']);
                Route::get('deletar/{id}', ['as' => 'store.destroy', 'uses' => 'StoreController@destroy']);
                Route::get('', ['as' => 'store.index', 'uses' => 'StoreController@index']);
            });
            Route::get('opcoes', ['as' => 'store.allOptions', 'uses' => 'StoreController@allOptions']);

        });
        Route::group(['prefix' => 'funcionarios-pagamentos'], function(){
            Route::group(['middleware' => ['role:admin|developer']], function(){
                Route::get('cadastrar', ['as' => 'employeeSalary.create', 'uses' => 'EmployeeSalaryController@create']);
                Route::post('cadastrar', ['as' => 'employeeSalary.store', 'uses' => 'EmployeeSalaryController@store']);
                Route::get('editar/{id}', ['as' => 'employeeSalary.edit', 'uses' => 'EmployeeSalaryController@edit']);
                Route::post('editar/{id}', ['as' => 'employeeSalary.update', 'uses' => 'EmployeeSalaryController@update']);
                Route::get('', ['as' => 'employeeSalary.index', 'uses' => 'EmployeeSalaryController@index']);
            });

        });

        Route::group(['prefix' => 'usuario', 'middleware' => ['role:admin|developer']], function(){
            Route::get('', ['as' => 'user.index', 'uses' => 'UserController@index']);
            Route::get('deletar/{id}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
            Route::get('cadastrar', ['as' => 'user.create', 'uses' => 'UserController@create']);
            Route::post('cadastrar', ['as' => 'user.store', 'uses' => 'UserController@store']);
            Route::get('editar/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
            Route::post('editar/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
        });
        
        Route::group(['prefix' => 'usuario'], function(){
            Route::get('opcoes-funcionarios', ['as' => 'user.allEmployeeUsers', 'uses' => 'UserController@allEmployeeUsers']);
            
        });

        Route::group(['prefix' => 'perfil'], function () {
            Route::get('opcoes', ['as' => 'role.allOptions', 'uses' => 'RoleController@allOptions']);
        });
        
        Route::group(['prefix' => 'relatorios'], function () {
            Route::get('buscas-por-periodo', ['as' => 'report.searchesbyPeriod', 'uses' => 'ReportController@searchesbyPeriod']);
            Route::get('excel-buscas-por-periodo', ['as' => 'report.searchesbyPeriodExcel', 'uses' => 'ReportController@searchesbyPeriodExcel']);
            Route::get('graficos-buscas-por-periodo', ['as' => 'report.searchesbyPeriodChart', 'uses' => 'ReportController@searchesbyPeriodChart']);

            Route::get('pets-atendidos-por-bairro', ['as' => 'report.petsAttendedByNeighborhood', 'uses' => 'ReportController@petsAttendedByNeighborhood']);
            Route::get('excel-pets-atendidos-por-bairro', ['as' => 'report.petsAttendedByNeighborhoodExcel', 'uses' => 'ReportController@petsAttendedByNeighborhoodExcel']);
            Route::get('graficos-pets-atendidos-por-bairro', ['as' => 'report.petsAttendedByNeighborhoodChart', 'uses' => 'ReportController@petsAttendedByNeighborhoodChart']);

            Route::get('pets-atendidos-por-raca', ['as' => 'report.petsAttendedByBreed', 'uses' => 'ReportController@petsAttendedByBreed']);
            Route::get('excel-pets-atendidos-por-raca', ['as' => 'report.petsAttendedByBreedExcel', 'uses' => 'ReportController@petsAttendedByBreedExcel']);
            Route::get('graficos-pets-atendidos-por-raca', ['as' => 'report.petsAttendedByBreedChart', 'uses' => 'ReportController@petsAttendedByBreedChart']);

            Route::get('despesas-por-periodo', ['as' => 'report.outlayByPeriod', 'uses' => 'ReportController@outlayByPeriod']);
            Route::get('excel-despesas-por-periodo', ['as' => 'report.outlayByPeriodExcel', 'uses' => 'ReportController@outlayByPeriodExcel']);
            Route::get('graficos-despesas-por-periodo', ['as' => 'report.outlayByPeriodChart', 'uses' => 'ReportController@outlayByPeriodChart']);
        
            Route::get('vendas-por-periodo', ['as' => 'report.salesByPeriod', 'uses' => 'ReportController@salesByPeriod']);
            Route::get('excel-vendas-por-periodo', ['as' => 'report.salesByPeriodExcel', 'uses' => 'ReportController@salesByPeriodExcel']);
            Route::get('graficos-vendas-por-periodo', ['as' => 'report.salesByPeriodChart', 'uses' => 'ReportController@salesByPeriodChart']);
        
            Route::get('balanco-financeiro', ['as' => 'report.financialStatement', 'uses' => 'ReportController@financialStatement']);
            Route::get('excel-balanco-financeiro', ['as' => 'report.financialStatementExcel', 'uses' => 'ReportController@financialStatementExcel']);
            Route::get('graficos-balanco-financeiro', ['as' => 'report.financialStatementChart', 'uses' => 'ReportController@financialStatementChart']);

        });
    });

    Route::get('dev/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

