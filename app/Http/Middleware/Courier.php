<?php

namespace App\Http\Middleware;

use Auth;
use Route;
use Closure;
use Illuminate\Http\Request;

class Courier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $myData = Auth::guard('courier')->user();
        if ($myData == "") {
            $currentRoute = Route::currentRouteName();
            return redirect()->route('courier.loginPage', ['r' => $currentRoute])->withErrors(['Anda harus login dulu sebelum melanjutkan kembali']);
        }
        return $next($request);
    }
}
