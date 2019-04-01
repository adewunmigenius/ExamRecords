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
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/result', 'HomeController@submit_ans')->name('user.submit');
Route::get('/all-results', 'HomeController@allUserResult')->name('user.results');

// Admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::post('exam/new', 'AdminController@setQuest')->name('admin.setexam');
    Route::post('exam/delete/{id}', 'AdminController@removeQuest')->name('admin.delexam');
    Route::get('/all-results', 'AdminController@allUserResult')->name('admin.allresults');
//    Route::get('/export-results', 'AdminController@exportCsv')->name('admin.exportresults');
});