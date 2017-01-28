<?php
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'visitors'], function() {
    Route::get('register', 'RegistrationController@register');
    Route::post('register', 'RegistrationController@postRegister');
    Route::get('login', 'LoginController@login');
    Route::post('login', 'LoginController@postLogin');
});

Route::post('logout', 'LoginController@logout');

Route::get('earnings', 'AdminController@earnings')->middleware('admin');

Route::get('tasks', 'ManagerController@tasks')->middleware('manager');