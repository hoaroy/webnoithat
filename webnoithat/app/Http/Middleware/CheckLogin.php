<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckLogin
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
        if (Auth::guest()) {
            return redirect()->route('login.index');
        }else{
            $check = User::where('id',Auth::user()->id)->first();
            if ($check->level != 1) {
                return $next($request);
            }else{
                // return $next($request);
                return redirect()->back();
            }
        }
    }
}
