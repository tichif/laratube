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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('channels','ChannelController');
Route::get('videos/{video}', 'VideosController@show');

Route::put('videos/{video}','VideosController@updateViews');
Route::put('videos/{video}/update','VideosController@update')->middleware(['auth'])->name('videos.update');

Route::get('videos/{video}/comments','CommentController@index');
Route::get('comments/{comment}/replies','CommentController@show');


Route::middleware(['auth'])->group(function(){
    Route::get('channels/{channel}/videos','UploadVideoController@index')->name('channel.upload');
    Route::post('channels/{channel}/videos','UploadVideoController@store');
    Route::resource('channels/{channel}/subscriptions','SubscriptionsController')->only('store','destroy');
    Route::post('/votes/{entityId}/{type}', 'VoteController@vote');
    Route::post('comments/{video}','CommentController@store');
});
