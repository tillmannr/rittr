<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetController extends Controller
{
	public function index(Request $request)
	{
		$tweetLogic = \App\Logic\Auth::create();
		print 'tweets';
//		return view('tweets.index');
	}
}
