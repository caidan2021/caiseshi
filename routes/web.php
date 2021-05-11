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



/**
 * 后台配置
 */
// Route::prefix('admin')->group(['middleware' => ['admin']], function ($router) {
//     $router->get('get_menu', 'Admin\Menu\MenuController@all')->name('admin.menu.get');
// });
Route::prefix('admin')->group(function ($router) {
    $router->get('get_menu', 'Admin\Menu\MenuController@all')->name('admin.menu.get');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
