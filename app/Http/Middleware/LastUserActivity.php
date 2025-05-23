<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;


class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $now_min = Carbon::now('Asia/Ho_Chi_Minh')->addSeconds(40);
        if (Auth::check()) {
            Cache::put('user-id-online-'.Auth::user()->id,true,$now_min);
        }
        return $next($request);
    }
}
