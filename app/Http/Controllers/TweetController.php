<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetController extends Controller
{

	public function __construct()
	{
		$this->middleware('user');
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
