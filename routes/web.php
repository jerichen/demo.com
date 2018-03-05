<?php

Route::get('/upload', 'UpdateController@index');
Route::post('/upload/file', 'UpdateController@updateFile');
Route::post('/delete/file', ['as' => 'delete.file', 'uses' => 'StorageController@deleteFile']);


Route::get('/imgur', 'ImgurController@index');
Route::post('/imgur/upload', 'ImgurController@imgurUpload');