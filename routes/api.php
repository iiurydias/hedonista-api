<?php

use Illuminate\Http\Request;


Route::post('/user', [
    'uses'=> 'UserController@create',
    'as' => 'create.user'
]);
Route::get('/login', [
    'uses'=> 'UserController@get',
    'as' => 'get.user'
]);
Route::middleware('auth:api')->group(function () {
    Route::get('/homedata', [
        'uses'=> 'HomeDataController@get',
        'as' => 'get.homeData'
    ]);
    Route::post('/tofavorite', [
        'uses'=> 'FavoriteController@create',
        'as' => 'create.favorite'
    ]);
    Route::delete('/unfavorite', [
        'uses'=> 'FavoriteController@delete',
        'as' => 'delete.favorite'
    ]);
    Route::get('/subcategories', [
        'uses'=> 'SubcategoryController@get',
        'as' => 'get.subcategory'
    ]);
    Route::post('/subcategory', [
        'uses'=> 'SubcategoryController@create',
        'as' => 'create.subcategory'
    ]);
    Route::get('/pointsbysubcategory', [
        'uses'=> 'PointController@get',
        'as' => 'get.point'
    ]);
    Route::post('/point', [
        'uses'=> 'PointController@create',
        'as' => 'create.point'
    ]);
});