<?php

// Middleware
use App\Http\Middleware\CheckMember;
use App\Http\Middleware\CheckAdmin;

Auth::routes();

Route::group(['middleware' => ['checkMember']], function () {
    Route::get('/','MessageController@index');
	Route::post('/message/store', 'MessageController@store')->name('home.store');
	Route::post('/delete', 'MessageController@delete')->name('home.delete');
	Route::post('/edit', 'MessageController@edit')->name('home.edit');
	Route::post('/destroy/{id}', 'MessageController@destroy')->name('home.destroy');
	Route::post('/update/{id}', 'MessageController@update')->name('home.update');
});

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/detailRegister', 'Auth\RegisterController@detailRegister');
Route::post('/successRegister', 'Auth\RegisterController@successRegister');
Route::get('/activation/{activationAccount}', 'Auth\RegisterController@activation');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@functionLogin')->name('loginSubmit');


Route::post('/loginFunction', 'Auth\LoginController@functionLogin');
Route::post('/cek_password', 'MessageController@checkPassword')->name("checkPassword");


Route::group(['middleware' => ['auth','checkAdmin']], function(){
	Route::get('/dashboard','DashboardController@index');
	Route::post('/dashboard', 'DashboardController@search')->name('dashboard');
	Route::post('/dashboard/delete/{id}', 'DashboardController@delete');
	Route::post('/dashboard/delete-image/{id}', 'DashboardController@deleteImage');
	Route::post('/dashboard/delete-multiply', 'DashboardController@deleteMultiply')->name('dashboard.deleteMultiply');
	Route::post('/dashboard/restore/{id}', 'DashboardController@restore');
});


