<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the session does not have 'adminSession'
        if (!Session::has('adminSession')) {
            // Redirect to the login page if not logged in
            return redirect()->route('login');
        }

        return $next($request); // Proceed with the request if logged in
    }
}
