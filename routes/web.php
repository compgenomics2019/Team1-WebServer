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

Route::get('assemble', function () {
    return view('assemble');
});

Route::get('predict', function () {
    return view('predict');
});

Route::get('annotation', function () {
    return view('annotation');
});

Route::get('compare', function () {
    return view('compare');
});

Route::get('upload', function () {
    return view('upload');
});

Route::post('upload/file_upload', 'Home\FileManagerController@upload');

Route::get('FileManager', 'Home\FileManagerController@index');

