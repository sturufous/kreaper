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
	Route::post('bandlist', 'HomeController@bandListInMSDB');
	Route::get('albumlist/{artist_id}', 'HomeController@albumListInMSDB');
	Route::get('tracklist/{album_id}', 'HomeController@trackListInMSDB');
	Route::get('showmsdblyrics/{track_id}', 'HomeController@getMSDBLyrics');
	Route::get('showlyrics/{track_id}', 'HomeController@getLyrics');
	Route::get('gettopten', 'HomeController@getTopTen');
	Route::get('makewordcloud/{track_id}', 'HomeController@makeWordCloud');
});

Route::auth();

Route::group(['middleware' => ['web']], function() {
	Route::get('/artisan/getbandpics', function () {
		Artisan::call('kreaper:getbandpics', []);
	});
	
	Route::get('/artisan/loadlyrics', function () {
		Artisan::call('kreaper:loadlyrics', []);
	});
	
	Route::get('/artisan/viewrelations', function () {
		Artisan::call('kreaper:viewrelations', []);
	});
});
