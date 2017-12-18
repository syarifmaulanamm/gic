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

Route::get('/', 'UsersController@login');
Route::get('login', 'UsersController@login');
Route::post('/', 'UsersController@doLogin');
Route::post('login', 'UsersController@doLogin');
Route::get('logout', 'UsersController@logout');


Route::group(['middleware' => ['login']], function () {
    // Home
    Route::get('home', 'HomeController@index');
    // Inventory
    Route::get('inventory', 'InventoryController@index');
    Route::post('inventory/create', 'InventoryController@create');
    Route::post('inventory/update', 'InventoryController@update');
    Route::post('inventory/in', 'InventoryController@stockIn');
    Route::post('inventory/out', 'InventoryController@stockOut');
    Route::get('inventory/out/{id}', 'InventoryController@getStockOut');
    Route::post('inventory/return', 'InventoryController@stockReturn');
    Route::get('inventory/export', 'InventoryController@export');
    Route::get('inventory/receipt/{type}/{id}', 'InventoryController@receipt');
    Route::get('inventory/{id}', 'InventoryController@read');
    Route::delete('inventory/{id}', 'InventoryController@delete');
    /** Purchase Order **/
    Route::get('po', 'PoController@index');
    Route::get('po/vendor', 'PoController@vendor');
    // Create
    Route::get('po/create', 'PoController@create');
    Route::post('po/create', 'PoController@doCreate');
    Route::get('po/vendor/create', 'PoController@createVendor');
    Route::post('po/vendor/create', 'PoController@doCreateVendor');
    // Update
    Route::get('po/update/{id}', 'PoController@update');
    Route::post('po/update/{id}', 'PoController@doUpdate');
    Route::post('po/item/update/{id}', 'PoController@updateItem');
    Route::post('po/attachment/update/{id}', 'PoController@updateAttachment');
    Route::get('po/vendor/update/{id}', 'PoController@updateVendor');
    Route::post('po/vendor/update/{id}', 'PoController@doUpdateVendor');
    // Delete
    Route::delete('po/{id}', 'PoController@delete');
    Route::delete('po/item/{id}', 'PoController@deleteItem');
    Route::delete('po/attachment/{id}', 'PoController@deleteAttachment');
    Route::delete('po/vendor/{id}', 'PoController@deleteVendor');
    // Read
    Route::get('po/{id}', 'PoController@read');
    Route::get('po/item/{id}', 'PoController@readItem');
    Route::get('po/attachment/{id}', 'PoController@readAttachment');
    // Route::get('po/vendor/{id}', 'PoController@readVendor');
    // Approval
    Route::post('po/approve/{id}', 'PoController@approval');
    // API
    Route::get('api/po/vendor/{id}', 'PoController@APIGetVendor');
    /**
     * Sales
     */
    // Create
    Route::get('sales/revenue/create', 'SalesController@createRevenue');
    Route::get('api/sales/revenue/m2m', 'SalesController@m2m');
    Route::get('api/sales/revenue/y2y', 'SalesController@y2y');
    Route::post('sales/revenue/create', 'SalesController@doCreateRevenue');
    Route::get('sales/client-status/create', 'SalesController@createClient');
    Route::post('sales/client-status/create', 'SalesController@doCreateClient');
    // Update
    Route::get('sales/client-status/update/{id}', 'SalesController@updateClient');
    Route::post('sales/client-status/update/{id}', 'SalesController@doUpdateClient');
    // Delete
    Route::delete('sales/client-status/{id}', 'SalesController@deleteClient');
    // Get
    Route::get('sales/client-status/{id}', 'SalesController@clientStatus');
    Route::get('sales/revenue', 'SalesController@revenue');
    Route::get('sales/client-status', 'SalesController@clientStatus');
    /**
     * Airlines
     */
    Route::get('airlines', 'AirlinesController@index');
    // Create
    Route::get('airlines/create', 'AirlinesController@create');
    Route::post('airlines/create', 'AirlinesController@doCreate');
});