<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsMerchant
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
        if(Auth::check()){
        if (Auth::user()->user_type == 'merchant') {
            return $next($request);
        }
        else{
           abort(403,'Unauthorized access');
        }
        }
        else{
            session(['link' => url()->current()]);
            return redirect()->route('user.mlogin');
        }
    }
}
