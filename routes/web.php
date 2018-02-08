<?php

Route::get('/update', 'UpdateController@index');
Route::post('/update/file', 'UpdateController@updateFile');
Route::post('/delete/file', ['as' => 'delete.file', 'uses' => 'StorageController@deleteFile']);