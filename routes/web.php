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
//grupo de rotas, através do filtro, com namespace padrão, rota padrão(admin)
$this->group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function(){
   $this->any('historic-search', 'BalanceController@searchHistoric')->name('historic.search');//rota de filtro, any(aceita qualquer tipo de requisição)
   
   
    $this->get('historic', 'BalanceController@historic')->name('admin.historic');//histórico
   
    $this->post('transfer', 'BalanceController@transferStore')->name('transfer.store');//form confirmação transferência
    $this->post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');//form transferência
    $this->get('transfer', 'BalanceController@transfer')->name('balance.transfer');//transferência
    

    $this->get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');//rota saque
    $this->post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');//form recarga
    
    $this->post('deposit', 'BalanceController@depositStore')->name('deposit.store');//formuláro recarga
    $this->get('deposit', 'BalanceController@deposit')->name('balance.deposit');//deposito
    
    $this->get('balance', 'BalanceController@index')->name('admin.balance');//exibir saldo
    $this->get('/', 'AdminController@index')->name('admin.home');//exibir o admin
});


//criar perfil
$this->get('meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');

$this->get('/', 'Site\SiteController@index')->name('home');//exibir a home

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
