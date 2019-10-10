<?php

//Route::get('/', 'Challenge30Controller@index');
Route::get('/','MessageController@index');
Route::post('/', 'MessageController@createMessage');
Route::post('/edit_message', 'MessageController@editMessage')->name("editMessage");
Route::post('/delete_message', 'MessageController@deleteMessage')->name("deleteMessage");
// Route::resource('/', 'Challenge30Controller');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/detailRegister', 'Auth\RegisterController@detailRegister');
Route::post('/successRegister', 'Auth\RegisterController@successRegister');
Route::get('/activationAccount/{activationCode}', 'Auth\RegisterController@activationAccount');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', function () {
  Auth::logout();
  return redirect("/");
});
Route::post('/loginFunction', 'Auth\LoginController@functionLogin');
Route::post('/cek_password', 'MessageController@checkPassword')->name("checkPassword");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
