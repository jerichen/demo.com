<?php

Route::get('/update', 'UpdateController@index');
Route::post('/update/post', 'UpdateController@updatePost');