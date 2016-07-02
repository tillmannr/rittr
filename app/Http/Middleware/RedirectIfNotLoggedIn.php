<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$authLogic    = \App\Logic\Auth::create();
		if (empty($request->session()->get('authUser')) ||
			!$authLogic->getUserIdByAuthKey($request->session()->get('authUser')))
		{
			return redirect(action('TweetController@auth'));
		}

        return $next($request);
    }
}
