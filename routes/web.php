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
})->middleware('CheckAdmin');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

/*
 * Admin
 */
Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
    Route::resource('user', 'UserController')->middleware('auth');
    Route::resource('depot', 'DepotController')->middleware('auth');
    Route::post('resetabc', 'HomeController@resetPassword')->name('user.reset-password');
    Route::get('export', 'UserController@export')->name('user.export');
    Route::get('export1', 'DepotController@export')->name('depot.export');
    Route::get('/checkMK', function(){
        return view('admin.checkMK');
    })->name('checkMK');
});

/*
 * Product
 */
Route::resource('product', 'ProductController')->middleware('auth');
Route::resource('depotProduct', 'depotProductController')->middleware('auth');
Route::post('depotProduct-{depotProduct}', 'depotProductController@update2')->name('depotProduct-update2');
/*
 * Export
 */
Route::get('exports', 'ProductController@export')->name('product.export');
Route::get('exportss', 'depotProductController@export')->name('depotProduct.export');

/*
 * Check
 */
Route::get('/logout', function(){
    Auth::logout();
    return view('auth.login');
})->name('out');
Route::get('/fails', function(){
    return view('admin.unauthorized');
})->name('role');
Route::post('/pass', 'checkMKController@postCredentials')->name('pass');

Route::resource('ajax-crud', 'AjaxController');

Route::post('user/edit', 'UserController@editUser')->name('user.root.edit');
Route::post('product/edit', 'ProductController@editProduct')->name('product.root.edit');


