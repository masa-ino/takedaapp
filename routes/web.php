<?php

// ユーザー
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

  // ログイン認証関連
  Auth::routes([
    'register' => true,
    'reset'    => false,
    'verify'   => false
  ]);

  // ログイン認証後
  Route::middleware('auth:user')->group(function () {

    // TOPページ
    Route::resource('home', 'HomeController', ['only' => 'index']);

    Route::get('/training_list', 'UserController@training_list')->name('training_list');

    Route::get('/training_edit', 'UserController@training_edit')->name('training_edit');

    Route::post('/training_edit', 'UserController@post_training_edit');
  });
});

// 管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

  // ログイン認証関連
  Auth::routes([
    'register' => true,
    'reset'    => false,
    'verify'   => false
  ]);

  // ログイン認証後
  Route::middleware('auth:admin')->group(function () {

    // TOPページ
    Route::resource('home', 'HomeController', ['only' => 'index']);

    Route::get('/create_user', 'AdminController@create_user')->name('create_user');

    Route::post('create_user', 'AdminController@post_create_user');

    Route::get('/user_list', 'AdminController@user_list')->name('user_list');

    Route::post('user/{user}/delete', 'AdminController@user_delete')->name('user_delete');

    Route::get('/user/{user}/edit', 'AdminController@user_edit')->name('user_edit');

    Route::post('/user/{user}/edit', 'AdminController@post_user_edit');

    Route::get('/training_search', 'AdminController@training_search')->name('training_search');

    Route::post('/training_search', 'AdminController@post_training_search')->name('training_search');

    Route::post('/training_search/{user}/{time}/result', 'AdminController@post_training_search_result')->name('training_search_result');

    Route::get('/training_reserved', 'AdminController@training_reserved')->name('training_reserved');

    Route::post('/training_reserved/{user}/result', 'AdminController@post_training_reserved')->name('training_reserved_result');
  });
});
