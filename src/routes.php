<?php

Route::group([

    'namespace' => 'Helious\SeatAssets\Http\Controllers',
    'prefix' => 'assets',
    'middleware' => [
        'web',
        'auth',
        'can:seat-assets.access',
    ],
], function()
{

    Route::get('/', [
        'uses' => 'AssetsController@index',
        'as' => 'seat-assets::index',
    ]);

});