<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsSeller
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
        if (Auth::user()->user_type == 'seller') {
            return $next($request);
        }
        else{
           abort(403,'Unauthorized access');
        }
        }
        else{
            session(['link' => url()->current()]);
            return redirect()->route('login');
        }
    }
}
