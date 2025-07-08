<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the admin session exists and if the current route is the login page
        if (session()->has('adminSession') && $request->routeIs('login')) {
            return redirect()->route('home'); // Redirect to home if already logged in
        }
        return $next($request); // Proceed with the request if not logged in
    }
}
