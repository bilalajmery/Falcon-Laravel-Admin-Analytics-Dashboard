<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RememberMe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session is not set
        if (!session()->has('adminSession')) {
            // Check if the cookie exists
            if ($request->hasCookie('email')) {
                $email = $request->cookie('email');

                // Query the admin table for the email
                $admin = Admin::where('email', $email)->first();

                if ($admin) {
                    // Set session with admin data
                    Session::put('adminSession', [
                        'adminId' => $admin->adminId,
                        'uid' => $admin->uid,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'profile' => $admin->profile,
                        'twoStepVerification' => $admin->twoStepVerification,
                        'phone' => $admin->phone,
                    ]);

                    return redirect('/home');
                } else {
                    // Forget the email cookie and redirect to login
                    Cookie::queue(Cookie::forget('email'));
                    return redirect('/login');
                }
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
