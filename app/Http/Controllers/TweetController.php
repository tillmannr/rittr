<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetController extends Controller
{

	public function __construct()
	{

	}

	public function index(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		print 'tweets';
//		return view('tweets.index');
	}

	public function tweets()
	{
		$authLogic = \App\Logic\Auth::create();
		$userId = $authLogic->getUserId('tillmannr');

		$tweetManager = \App\Logic\TweetManager::create();
		$tweetManager->saveTweet($userId, md5(time()));
		dd($tweetManager->getAll());
	}
}
