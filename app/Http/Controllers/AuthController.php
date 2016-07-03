<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
	public function showLoginForm()
	{
		return view('auth');
	}

	public function login(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		$authKey = $authLogic->auth($request->input('userName'), $request->input('password'));
		if (!$authKey) {
			return redirect(action('AuthController@showLoginForm'));
		}
		$request->session()->put('authUser', $authKey);
		return redirect(action('TweetController@timeline'));
	}

	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect(action('TweetController@timeline'));
	}

	public function showRegistrationForm()
	{
		return view('register');
	}

	public function register(Request $request)
	{
		$authLogic = \App\Logic\Auth::create();
		if ($authLogic->register($request->input('userName'), $request->input('password')) === false) {
			return redirect(action('AuthController@register'));
		}
		return redirect(action('AuthController@showLoginForm'));
	}
}
