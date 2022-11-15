<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'],function(){
    

});

Route::prefix('admin')->group(function() {
    Route::get('/super','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/super', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');

    Route::resource('data-kuisioner', 'Admin\DataKuisionerController');

    Route::resource('select-data', 'Admin\SelectDataController');
    Route::get('/select-data/{id}','Admin\SelectDataController@index')->name('select.data');
    Route::get('/select-datas/{id}','Admin\SelectDataController@listOption')->name('list.option');
    Route::delete('/select-data/{id}','Admin\SelectDataController@destroy')->name('del.option');
}) ;
