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
    return view('template.front.index');
});

Route::get('Costumer/costumer-menu', 'CostumerController@index')->name('costumer');
Route::get('Costumer/costumer-table', 'CostumerController@pilih_meja')->name('costumer');
Route::get('/Costumer/cek_menu/{id}', 'CostumerController@getmenu')->name('co.getmenu');
Route::get('/Costumer/get_detail_menu/{id}', 'CostumerController@get_detail_menu')->name('co.get_detail_menu');
Route::post('/Costumer/store_table', 'CostumerController@store_table')->name('store_table');
Route::post('/Costumer/store_trans', 'CostumerController@store_trans')->name('co.store_transs');

Route::get('/employee', 'MasterController@employee')->name('employee')->middleware('auth:manager');

Auth::routes();
Route::namespace ('Auth')->group(function () {
    // Controllers Within The "App\Http\Controllers\Auth" Namespace
    Route::get('/login', 'LoginController@getLogin')->middleware('guest');
    Route::post('/login', 'LoginController@postLogin')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::name('Cashier')->middleware('auth:cashier')->group(function () {
    Route::get('/Cashier/cashier', 'CashierController@index')->name('cashier');
    Route::get('/Cashier/check-out', 'CashierController@checkout')->name('checkout');
    Route::get('/Cashier/cek_menu/{id}', 'CashierController@getmenu')->name('getmenu');
    Route::get('/Cashier/get_detail_menu/{id}', 'CashierController@get_detail_menu')->name('get_detail_menu');
    Route::get('/Cashier/get_supplier/{id}', 'CashierController@getmenu')->name('getmenu');
    Route::post('/Cashier/store_trans', 'CashierController@store_trans')->name('store_trans');
    Route::get('/Cashier/cetak_struk/{id}', 'CashierController@cetak_struk')->name('cetak_struk');
    Route::post('/Cashier/finishing', 'CashierController@finishing')->name('finishing');

});

Route::name('Manager')->middleware('auth:manager')->group(function () {
    Route::get('/Manager/dashboard', 'ManagerController@index')->name('master');
    Route::get('/Manager/employee', 'ManagerController@employee')->name('employee');
    Route::get('/Manager/get_data_emp/{id}', 'ManagerController@get_data_emp')->name('get_data_emp');
    Route::get('/Manager/transaksi', 'ManagerController@transaksi')->name('manager.transaksi');
    Route::get('/Manager/po', 'ManagerController@purchase_order')->name('manager.purchase_order');

    route::post('/Manager/store_employee', 'ManagerController@store_employee')->name('store_employee');

});

Route::name('Purchasing')->middleware('auth:purchasing')->group(function () {
    Route::get('/Purchasing/master-dashboard', 'MasterController@index_dashboard')->name('master_dashboard');
    Route::get('/Purchasing/permintaan-pembelian', 'MasterController@permintaan_pembelian')->name('permintaan_pembelian');
    Route::get('/Purchasing/permintaan_barang_koki', 'MasterController@permintaan_barang_koki')->name('permintaan_barang_koki');

    Route::get('/Purchasing/purchasing-order', 'MasterController@purchasing_order')->name('purchasing_order');
    Route::get('/Purchasing/surat-terima_barang', 'MasterController@surat_terima_barang')->name('surat_terima_barang');
    Route::get('/Purchasing/payment-voucher', 'MasterController@payment_voucher')->name('payment_voucher');
    Route::get('/Purchasing/master-barang', 'MasterController@master_barang')->name('master_barang');
    Route::get('/Purchasing/supplier', 'MasterController@supplier')->name('supplier');
    Route::get('/Purchasing/cetak_pv', 'MasterController@cetak_pv')->name('cetak_pv');
    Route::get('/Purchasing/print_pv/{id}', 'MasterController@print_pv')->name('surveyor.print_pv');

    
    Route::get('/Purchasing/get_detail_barang/{id_barang}', 'MasterController@get_detail_barang')->name('get_detail_barang');
    Route::get('/Purchasing/get_supp/{id_supp}', 'MasterController@get_supp')->name('get_supp');

    Route::get('/Purchasing/get_pp/{id_pp}', 'MasterController@get_data_pp')->name('get_data_pp');
    Route::get('/Purchasing/get_po/{id_po}', 'MasterController@get_data_po')->name('get_data_po');
    Route::get('/Purchasing/get_stb/{id_stb}', 'MasterController@get_data_stb')->name('get_data_stb');

    Route::post('/Purchasing/store_supp', 'MasterController@store_supp')->name('pu.store_supp');
    Route::post('/Purchasing/store_po', 'MasterController@store_po')->name('pu.store_po');
    Route::post('/Purchasing/store_koki', 'MasterController@store_koki')->name('pu.store_koki');

    Route::post('/Purchasing/store_barang', 'MasterController@store_barang')->name('pu.store_barang');
    Route::post('/Purchasing/insert-pembelian', 'MasterController@insert_pembelian')->name('insert_pembelian');
    Route::post('/Purchasing/store_stb', 'MasterController@store_stb')->name('pu.store_stb');
    Route::post('/Purchasing/store_pv', 'MasterController@store_pv')->name('pu.store_pv');
    Route::post('/Purchasing/update_barang', 'MasterController@update_barang')->name('pu.update_barang');

    // Route::post('/Purchasing/permintaan_pembelian', 'MasterController@permintaan_pembelian')->name('pu.permintaan_pembelian');
    // Route::post('/Purchasing/purchasing_order', 'MasterController@purchasing_order')->name('pu.purchasing_order');
    // Route::post('/Purchasing/payment_voucher', 'MasterController@payment_voucher')->name('pu.payment_voucher');
    // Route::post('/Purchasing/surat_terima_barang', 'MasterController@surat_terima_barang' )->name('pu.surat_terima_barang');
});
Route::name('Koki')->middleware('auth:koki')->group(function () {
    Route::get('/Koki/dashboard', 'KokiController@index')->name('index');
    Route::get('/Koki/list-order', 'KokiController@list_order')->name('list-order');
    Route::get('/Koki/data-menu', 'KokiController@data_menu')->name('data_menu');
    Route::get('/Koki/permintaan-pembelian', 'KokiController@permintaan_pembelian')->name('permintaan_pembelian');
    Route::post('/Koki/insert_pembelian', 'KokiController@insert_pembelian')->name('insert_pembelian');
    Route::get('/Koki/get_detail_barang/{id_barang}', 'KokiController@get_detail_barang')->name('get_detail_barang');
    Route::get('/Koki/get_detail_menu/{id}', 'KokiController@get_detail_menu')->name('chef.get_detail_menu');

    Route::post('/Koki/store_menu', 'KokiController@store_menu')->name('chef.store_menu');
    Route::post('/Koki/update_status', 'KokiController@update_status')->name('chef.update_status');
    Route::post('/Koki/update_menu', 'KokiController@update_menu')->name('chef.update_menu');

});
/*AHMAD ZAKKY*/
