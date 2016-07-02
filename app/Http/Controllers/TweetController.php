<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetController extends Controller
{

	public function __construct()
	{
		$this->middleware('user', ['only' => 'timeline']);
	}

	public function auth()
	{
		return view('auth');
	}

	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect(action('TweetController@timeline'));
	}

	public function doAuth(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		$authKey = $authLogic->auth($request->input('userName'), $request->input('password'));
		if (!$authKey) {
			return redirect(action('TweetController@auth'));
		}
		$request->session()->put('authUser', $authKey);
		return redirect(action('TweetController@timeline'));
	}

	public function register()
	{
		return view('register');
	}

	public function createRegistration(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		if ($authLogic->register($request->input('userName'), $request->input('password')) === false) {
			return redirect(action('TweetController@register'));
		}
		return redirect(action('TweetController@auth'));
	}

	public function timeline()
	{
		$tweetManager = \App\Logic\TweetManager::create();
		return view('timeline', [
			'tweets' => $tweetManager->getAll(),
		]);
	}

	public function createTweet(Request $request)
	{
		$authLogic    = \App\Logic\Auth::create();
		$tweetManager = \App\Logic\TweetManager::create();
		$userId       = $authLogic->getUserIdByAuthKey($request->session()->get('authUser'));

		$tweetManager->saveTweet($userId, $request->input('tweet'));
		return redirect(action('TweetController@timeline'));
	}
}
