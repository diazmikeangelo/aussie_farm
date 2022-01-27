<?php

Route::get('/test', function () {
    return view('template.main2');
});
Route::get('/', 'KangarooController@index');
Route::get('/kangaroos/create', 'KangarooController@create');
Route::get('/kangaroos/{kangaroo}/edit', 'KangarooController@edit');
