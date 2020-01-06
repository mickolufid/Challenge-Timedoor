<?php

// Middleware
use App\Http\Middleware\CheckMember;
use App\Http\Middleware\CheckAdmin;

Auth::routes();

Route::group(['middleware' => ['checkMember']], function () {
    Route::get('/','Users\MessageController@index');
	Route::post('/message/store', 'Users\MessageController@store')->name('home.store');
	Route::post('/delete', 'Users\MessageController@delete')->name('home.delete');
	Route::post('/edit', 'Users\MessageController@edit')->name('home.edit');
	Route::post('/destroy/{id}', 'Users\MessageController@destroy')->name('home.destroy');
	Route::post('/update/{id}', 'Users\MessageController@update')->name('home.update');
});

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/detailRegister', 'Auth\RegisterController@detailRegister');
Route::post('/successRegister', 'Auth\RegisterController@successRegister');
Route::get('/activation/{activationAccount}', 'Auth\RegisterController@activation');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@functionLogin')->name('loginSubmit');


Route::post('/loginFunction', 'Auth\LoginController@functionLogin');
Route::post('/cek_password', 'Users\MessageController@checkPassword')->name("checkPassword");


Route::group(['middleware' => ['auth','checkAdmin']], function(){
	Route::get('/admin','Admin\DashboardController@index');
	Route::post('/admin', 'Admin\DashboardController@search')->name('dashboard');
	Route::post('/admin/delete/{id}', 'Admin\DashboardController@delete');
	Route::post('/admin/delete-image/{id}', 'Admin\DashboardController@deleteImage');
	Route::post('/admin/delete-multiply', 'Admin\DashboardController@deleteMultiply')->name('dashboard.deleteMultiply');
	Route::post('/admin/restore/{id}', 'Admin\DashboardController@restore');
});


