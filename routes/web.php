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

Route::prefix('admin')->group(function ($router) {
    $router->any('login', 'Admin\Login\LoginController@login');
    $router->get('logout', 'Admin\Login\LoginController@logOut');
    $router->get('add_user', 'Admin\Login\LoginController@addAdminUser');
});



Route::prefix('admin')->group(function ($router) {

    //tools
    $router->post('tools/uploadImage', 'Admin\Tools\FileController@uploadImage');


    //product
    $router->get('/products/list', 'Admin\Products\ProductsController@list');
    $router->post('/products/save', 'Admin\Products\ProductsController@save');


    //sku
    $router->get('/products/sku/list', 'Admin\Products\ProductSkusController@getListForProduct');
    $router->get('/products/sku/edit', 'Admin\Products\ProductSkusController@edit');
    $router->post('/products/sku/modules/save', 'Admin\Products\ProductSkusController@saveByModules');
    $router->post('/products/sku/save', 'Admin\Products\ProductSkusController@save');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
