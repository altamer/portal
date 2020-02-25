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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/image/store', 'ImageController@store');

Route::post('/addmachine', 'MachinesController@addmachine');
Route::post('/addinsurance', 'KindlustusController@addinsurance');
Route::get('/checkdue', 'KindlustusController@checkdue');
Route::get('/getdue', 'KindlustusController@getdue');
Route::get('/getmachines', 'MachinesController@getmachines');
Route::post('/setinsurancestatus', 'KindlustusController@setinsurancestatus');
Route::post('/setmachinestatus', 'MachinesController@setmachinestatus');
Route::post('/updatemachine', 'MachinesController@updatemachine');
Route::post('/updateinsurance', 'KindlustusController@updateinsurance');


