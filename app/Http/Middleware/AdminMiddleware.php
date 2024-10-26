<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Kullanıcı giriş yapmış ve admin değilse ana sayfaya yönlendir
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
