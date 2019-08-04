<?php

use Illuminate\Http\Request;


Route::post('/createUser', [
    'uses'=> 'UserController@create',
    'as' => 'create.user'
]);
Route::get('/login', [
    'uses'=> 'UserController@get',
    'as' => 'get.user'
]);
Route::middleware('auth:api')->group(function () {
    Route::get('/getHomeData', [
        'uses'=> 'HomeDataController@get',
        'as' => 'get.homeData'
    ]);
    Route::post('/toFavorite', [
        'uses'=> 'FavoriteController@create',
        'as' => 'create.favorite'
    ]);
    Route::delete('/unfavorite', [
        'uses'=> 'FavoriteController@delete',
        'as' => 'delete.favorite'
    ]);
    Route::get('/getSubcategories', [
        'uses'=> 'SubcategoryController@get',
        'as' => 'get.subcategory'
    ]);
    Route::post('/createSubcategory', [
        'uses'=> 'SubcategoryController@create',
        'as' => 'create.subcategory'
    ]);
    Route::get('/getPointsBySubcategory', [
        'uses'=> 'PointController@get',
        'as' => 'get.point'
    ]);
    Route::post('/createPoint', [
        'uses'=> 'PointController@create',
        'as' => 'create.point'
    ]);
});