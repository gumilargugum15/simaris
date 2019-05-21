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



Auth::routes();
Route::group([ 'middleware' => 'auth' ], function (){ 
    Route::get('/', 'HomeController@index')->name('home'); 
});
Route::group(['middleware'=>['role:keyperson|verifikatur|pimpinanunit|managergcg']], function () {
    Route::get('/sumberrisiko/{id}','ResikobisnisController@sumberrisiko');
    Route::post('/sesuaikaidah','ResikobisnisController@sesuaikaidah');
    Route::post('/tidaksesuaikaidah','ResikobisnisController@tidaksesuaikaidah');
});

Route::group(['middleware'=>['role:keyperson']], function () {
    Route::get('/resikobisnis', 'ResikobisnisController@index')->name('resikobisnis.index');
    Route::post('/store','ResikobisnisController@store');
    Route::get('/getmatrixrisiko/{peluangid}/{dampakid}','ResikobisnisController@getmatrixrisiko');
    Route::get('/validasibisnis/{id}','ResikobisnisController@validasibisnis');
    Route::get('/batalvalidasibisnis/{id}','ResikobisnisController@batalvalidasibisnis');
    Route::get('/addrisikobisnis','ResikobisnisController@create');
});

Route::group(['middleware'=>['role:verifikatur']], function () {
    
    Route::get('/resikobisnisverifikatur', 'RiskbisnisverifController@index');
    Route::get('/validasibisnisverif/{id}','RiskbisnisverifController@validasibisnis');
    Route::get('/batalvalidasibisnisverif/{id}','RiskbisnisverifController@batalvalidasibisnis');
});
Route::group(['middleware'=>['role:pimpinanunit']], function () {
    Route::get('/resikobisnispimpinan', 'RiskbisnispimpinanController@index');
    Route::get('/validasibisnispimpinan/{id}','RiskbisnispimpinanController@validasibisnis');
    Route::get('/batalvalidasibisnispimpinan/{id}','RiskbisnispimpinanController@batalvalidasibisnis');
    
});
Route::group(['middleware'=>['role:managergcg']], function () {
    Route::get('/resikobisnismanagergcg', 'RiskbisnismanagController@index');
    Route::get('/validasibisnismanagergcg/{id}','RiskbisnismanagController@validasibisnis');
    Route::get('/batalvalidasibisnismanagergcg/{id}','RiskbisnismanagController@batalvalidasibisnis');
    
});