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

	public function auth()
	{
		return view('auth');
	}

	public function doAuth(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		if (!$authLogic->auth($request->input('userName'), $request->input('password'))) {
			return redirect('/auth');
		}
		return redirect('/tweets');
	}

	public function register(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		return view('register');
	}

	public function doRegistration(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		if ($authLogic->register($request->input('userName'), $request->input('password')) === false) {
			return redirect('/register');
		}
		return redirect('/auth');
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
