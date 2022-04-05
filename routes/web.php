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
Route::view('index', 'view.index')->name('map.index');

Auth::routes();
Route::resource('pref_id', 'PostsController', ['only' => ['index', 'show', 'create', 'store']]);
Route::get('pref_id/{pref_id}/{comment}', 'PostsController@show')->name('show_comment');
Route::resource('comment', 'CommentsController', ['only' => ['store']]);
Route::get('nice', 'NiceController@nice')->name('nice');
Route::get('unnice', 'NiceController@unnice')->name('unnice');
Route::group(['middleware' => 'auth'], function () {

    // ユーザ関連
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);
    Route::delete('pref/{pref_id?}/{post_id}', 'PostsController@destroy')->name('destroy');
});
