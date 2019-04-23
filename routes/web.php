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
    return view('index');
});

Route::get('about', function () {
    return view('about');
});

Route::get('output/{jobname}', 'Home\FileManagerController@make_out');

Route::get('output2', function () {
    return view('output2');
});

Route::get('/', 'Home\FileManagerController@get_file_list');

Route::get('start_ajax', 'Home\FileManagerController@ajax_analysis');

//Route::get('analysis/start', 'Home\FileManagerController@start_analysis');


Route::get('analysis/{status}', 'Home\FileManagerController@get_file_list');

Route::post('FileManager/file_upload', 'Home\FileManagerController@upload');

Route::post('FileManager/file_downloadOrDelete', 'Home\FileManagerController@downloadOrDelete');

Route::get('FileManager/{status}', 'Home\FileManagerController@index');
