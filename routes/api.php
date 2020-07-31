<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {
    $api->get('test', function() {
         return 1;
    });
});
	Route::get('provinsi', 'Api\AlamatController@provinsi');
	Route::get('kabupaten/{id}', 'Api\AlamatController@kabupaten');
	Route::post('register', 'Api\UserController@register');
    Route::post('login', 'Api\UserController@login');

    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('user', 'Api\UserController@detail');
        Route::put('user', 'Api\UserController@update');

        // SAWAHCONTROLLER 
        Route::get('sawah', 'Api\SawahController@index'); // data sawah berdasarkan id yang login
        Route::post('sawah', 'Api\SawahController@store'); // mendaftarkan sawah berdasarkan id yang login
        Route::put('sawah/{id}', 'Api\SawahController@update'); //edit sawah berdasarkan id sawah (tidak bisa edit jika data terdapat di table lain)
        Route::delete('sawah/{id}', 'Api\SawahController@delete'); //hapus sawah berdasarkan id sawah
        // END SAWAHCONTROLLER


        // GADAI SAWAH
        Route::get('gadai-sawah', 'Api\GadaiSawahController@index');
        Route::post('gadai-sawah', 'Api\GadaiSawahController@store');
        // END GADAI SAWAH

    });
