<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'TweetController@timeline');
Route::get('/login', 'AuthController@showLoginForm');
Route::get('/logout', 'AuthController@logout');
Route::post('/login/create', 'AuthController@login');

Route::get('/registration', 'AuthController@showRegistrationForm');
Route::post('/registration/create', 'AuthController@register');

Route::post('/tweet/create', 'TweetController@createTweet');