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
Route::group(['middleware'=>['role:keyperson|verifikatur|pimpinanunit|managergcg|superadmin']], function () {
    Route::get('/sumberrisiko/{id}','ResikobisnisController@sumberrisiko');
    Route::get('/readkomen/{id}','RiskbisnisverifController@readkomen');
    Route::get('/sumberrisikoproject/{id}','RisikoprojectController@sumberrisiko');
    Route::post('/importkpi','KpiController@import');
    
});
Route::group(['middleware'=>['role:verifikatur|superadmin|']], function () {
    //periodebisnis
    Route::get('/periodebisnis', 'PeriodebisnisController@index')->name('periodebisnis.index');
    Route::get('/addperiodbisnis','PeriodebisnisController@create');
    Route::post('/storeperiodbisnis','PeriodebisnisController@store');
    Route::get('/editperiodbisnis/{id?}','PeriodebisnisController@edit');
    Route::get('/aktifperiode/{id?}','PeriodebisnisController@aktifperiode');
    Route::get('/risikokrirkap', 'RiskbisnisverifController@krirkap');
    Route::get('/destroyperiodbisnis/{id?}','PeriodebisnisController@destroy');
    //kpi
    Route::get('/kpi', 'KpiController@index')->name('kpi.index');
    Route::get('/addkpi','KpiController@create');
    Route::post('/storekpi','KpiController@store');
    
    Route::get('/editkpi/{id?}','KpiController@edit');
    Route::post('/updatekpi','KpiController@update');
    Route::get('/destroykpi/{id?}','KpiController@destroy');
    // nama project
    Route::get('/project', 'ProjectController@index')->name('project.index');
    Route::get('/addproject','ProjectController@create');
    Route::get('/carikeyperson/{nikkeyperson}','ProjectController@carikeyperson');
    Route::post('/storeproject','ProjectController@store');
    Route::get('/editproject/{id?}','ProjectController@edit');
    Route::post('/updateproject','ProjectController@update');
    //risiko bisnis
    Route::get('/resikobisnisverifikatur', 'RiskbisnisverifController@index');
    Route::get('/validasibisnisverif/{id}','RiskbisnisverifController@validasibisnis');
    Route::get('/batalvalidasibisnisverif/{id}','RiskbisnisverifController@batalvalidasibisnis');
    Route::post('/sesuaikaidah','RiskbisnisverifController@sesuaikaidah');
    Route::post('/tidaksesuaikaidah','RiskbisnisverifController@tidaksesuaikaidah');
    Route::post('/highlight','RiskbisnisverifController@highlight');
    Route::post('/batalhighlight','RiskbisnisverifController@batalhighlight');
    Route::post('/kirimkomentar','RiskbisnisverifController@kirimkomentar');
    Route::get('/kpiverifikatur', 'RiskbisnisverifController@kpi')->name('kpiverifikatur.index');
    Route::post('/kri','RiskbisnisverifController@kri');
    Route::post('/batalkri','RiskbisnisverifController@batalkri');
    Route::post('/rkap','RiskbisnisverifController@rkap');
    Route::post('/batalrkap','RiskbisnisverifController@batalrkap');
    Route::get('/resikobisnisadmin', 'RiskbisnisverifController@index');
    Route::get('/laprisikobisnis', 'LaprisikobisnisController@index');
    Route::get('/export', 'LaprisikobisnisController@export');
    //otorisasi kpi
    Route::get('/userkeyperson', 'UserkeypersonController@index')->name('userkeyperson.index');
    Route::get('/bukaotorisasi/{nik}','UserkeypersonController@bukaotorisasi');
    Route::get('/tutupotorisasi/{nik}','UserkeypersonController@tutupotorisasi');
    //users
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::get('/nonaktifuser/{nik}','UsersController@nonaktifuser');
    Route::get('/aktifkanuser/{nik}','UsersController@aktifkanuser');
    Route::get('/addusers','UsersController@create');
    Route::get('/carinik/{nik}','UsersController@carinik');
    Route::post('/storeusers','UsersController@store');
    Route::get('/edituser/{id?}','UsersController@edit');
    Route::post('/updateusers','UsersController@update');
    
});

    Route::group(['middleware'=>['role:keyperson']], function () {
    Route::get('/resikobisnis', 'ResikobisnisController@index')->name('resikobisnis.index');
    Route::post('/store','ResikobisnisController@store');
    Route::get('/getmatrixrisiko/{peluangid}/{dampakid}','ResikobisnisController@getmatrixrisiko');
    Route::get('/validasibisnis/{id}','ResikobisnisController@validasibisnis');
    Route::get('/batalvalidasibisnis/{id}','ResikobisnisController@batalvalidasibisnis');
    Route::get('/addrisikobisnis','ResikobisnisController@create');
    Route::get('/edit/{id?}','ResikobisnisController@edit');
    Route::post('/update','ResikobisnisController@update');
    Route::get('/destroy/{id?}','ResikobisnisController@destroy');
    Route::get('/kpikeyperson', 'ResikobisnisController@kpi')->name('kpikeyperson.index');
    Route::get('/addkpikeyperson','ResikobisnisController@addkpi');
    Route::post('/storekpikeyperson','ResikobisnisController@storekpi');
    Route::get('/editkpikeyperson/{id?}','ResikobisnisController@editkpi');
    Route::post('/updatekpikeyperson','ResikobisnisController@updatekpi');
    Route::get('/destroykpikeyperson/{id?}','ResikobisnisController@destroykpi');
    Route::post('/kirimkomentarkeyperson','ResikobisnisController@kirimkomentarkeyperson');
    Route::post('/importkpikeyperson','ResikobisnisController@importkpikeyperson');
    //risiko aset
    Route::get('/risikoaset', 'RisikoasetController@index')->name('risikoaset.index');
    Route::get('/addrisikoaset','RisikoasetController@create');
    //risiko project
    Route::get('/risikoproject', 'RisikoprojectController@index')->name('risikoproject.index');
    Route::get('/addrisikoproject','RisikoprojectController@create');
    Route::post('/storeriskproject','RisikoprojectController@store');
    Route::get('/editriskproject/{id?}','RisikoprojectController@edit');
    Route::post('/updateriskproject','RisikoprojectController@update');
    Route::get('/destroyriskproject/{id?}','RisikoprojectController@destroy');
    Route::get('/validriskproject/{id}','RisikoprojectController@validriskproject');
    Route::get('/batalvalidasiproject/{id}','RisikoprojectController@batalvalidasiproject');
    Route::post('/levelbiasa','ResikobisnisController@levelbiasa');
    Route::post('/levelhight','ResikobisnisController@levelhight');
    Route::post('/kpiutama','ResikobisnisController@kpiutama');
    Route::post('/batalkpiutama','ResikobisnisController@batalkpiutama');
    
});

Route::group(['middleware'=>['role:verifikatur']], function () {
    
    // Route::get('/resikobisnisverifikatur', 'RiskbisnisverifController@index');
    // Route::get('/validasibisnisverif/{id}','RiskbisnisverifController@validasibisnis');
    // Route::get('/batalvalidasibisnisverif/{id}','RiskbisnisverifController@batalvalidasibisnis');
    // Route::post('/sesuaikaidah','RiskbisnisverifController@sesuaikaidah');
    // Route::post('/tidaksesuaikaidah','RiskbisnisverifController@tidaksesuaikaidah');
    // Route::post('/highlight','RiskbisnisverifController@highlight');
    // Route::post('/batalhighlight','RiskbisnisverifController@batalhighlight');
    // Route::post('/kirimkomentar','RiskbisnisverifController@kirimkomentar');
    // Route::get('/kpiverifikatur', 'RiskbisnisverifController@kpi')->name('kpiverifikatur.index');
    // Route::post('/kri','RiskbisnisverifController@kri');
    // Route::post('/batalkri','RiskbisnisverifController@batalkri');
    // Route::post('/rkap','RiskbisnisverifController@rkap');
    // Route::post('/batalrkap','RiskbisnisverifController@batalrkap');
    
    
    
    //risiko project
    Route::get('/risikoprojectverifikatur', 'RisikoprojectverifController@index')->name('risikoprojectperif.index');
    Route::get('/validriskprojectverif/{id}','RisikoprojectverifController@validriskproject');
    Route::get('/batalvalidriskprojectverif/{id}','RisikoprojectverifController@batalvalidriskproject');
    Route::post('/sesuaikaidahproject','RisikoprojectverifController@sesuaikaidah');
    Route::post('/tidaksesuaikaidahproject','RisikoprojectverifController@tidaksesuaikaidah');
});
Route::group(['middleware'=>['role:pimpinanunit']], function () {
    Route::get('/resikobisnispimpinan', 'RiskbisnispimpinanController@index')->name('resikobisnispimpinan.index');
    Route::get('/validasibisnispimpinan/{id}','RiskbisnispimpinanController@validasibisnis');
    Route::get('/batalvalidasibisnispimpinan/{id}','RiskbisnispimpinanController@batalvalidasibisnis');
    Route::get('/editatasan/{id?}','RiskbisnispimpinanController@edit');
    Route::post('/updaterbisnisatasan','RiskbisnispimpinanController@update');
    Route::get('/getmatrixrisikopimpinan/{peluangid}/{dampakid}','RiskbisnispimpinanController@getmatrixrisiko');
});
Route::group(['middleware'=>['role:managergcg']], function () {
    Route::get('/resikobisnismanagergcg', 'RiskbisnismanagController@index');
    Route::get('/validasibisnismanagergcg/{id}','RiskbisnismanagController@validasibisnis');
    Route::get('/batalvalidasibisnismanagergcg/{id}','RiskbisnismanagController@batalvalidasibisnis');
    
});
Route::group(['middleware'=>['role:superadmin']], function () {
    
    //unit
    Route::get('/unit', 'UnitController@index')->name('unit.index');
    Route::get('/updateunit','UnitController@updateunit');
    Route::get('/addunit','UnitController@create');
    Route::post('/storeunit','UnitController@store');
    Route::get('/destroyunit/{id?}','UnitController@destroy');
    
    
});