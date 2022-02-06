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

// Route::get('/pref/{pref_id}/', 'PostsController@index');
Route::resource('pref/{pref_id?}', 'PostsController', ['only' => ['index',  'create', 'store']]);
Route::get('pref/{pref_id?}/show/{post_id?}', 'PostsController@show')->name('show');
// Route::get('pref/{pref_id?}/{post_id}/show', 'PostsController@show')->name('show');
Route::get('pref/{pref_id?}/show/{post_id?}/{comment}', 'PostsController@show')->name('show_comment');
Route::resource('comment', 'CommentsController', ['only' => ['store']]);
Route::get('/pref/{pref_id?}/nice/{post_id}', 'NiceController@nice')->name('nice');
Route::get('/pref/{pref_id?}/unnice/{post_id}', 'NiceController@unnice')->name('unnice');
Route::group(['middleware' => 'auth'], function() {

    // ユーザ関連
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);
    Route::delete('pref/{pref_id?}/{post_id}', 'PostsController@destroy')->name('destroy');

});