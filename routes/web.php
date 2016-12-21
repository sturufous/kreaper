<?php

//use function PhpParser\function;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['web','auth']], function() {
	Route::get('/', 'HomeController@index');
	Route::get('bandentry', 'HomeController@bandEntry');
	Route::post('bandlist', 'HomeController@bandList');
	Route::get('extract/{artist_id}', 'HomeController@extractAlbums');
});

Route::auth();


