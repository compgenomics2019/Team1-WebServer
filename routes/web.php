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

Route::get('assemble', 'Home\FileManagerController@assemble_file_list');

Route::get('predict', 'Home\FileManagerController@prediction_file_list');

Route::get('annotation', 'Home\FileManagerController@annotation_file_list');

Route::get('compare', 'Home\FileManagerController@comparative_file_list');

Route::get('upload', function () {
    return view('upload');
});

Route::post('file/file_upload', 'Home\FileManagerController@upload');

Route::post('file/file_download', 'Home\FileManagerController@download');

Route::get('FileManager', 'Home\FileManagerController@index');

