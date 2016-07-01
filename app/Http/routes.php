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

Route::get('/', 'TweetController@index');
Route::get('/auth', 'TweetController@auth');
Route::post('/doauth', 'TweetController@doAuth');

Route::get('/registration', 'TweetController@register');
Route::post('/registration/create', 'TweetController@createRegistration');

Route::post('/tweet/create', 'TweetController@createTweet');

Route::get('/timeline', 'TweetController@timeline');
