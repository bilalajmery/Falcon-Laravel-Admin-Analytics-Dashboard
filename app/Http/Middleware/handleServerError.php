<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\commonFunction; // Adjust namespace as necessary

class handleServerError extends commonFunction // Capitalized class name
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Process the request
            return $next($request);
        } catch (\Throwable $exception) {
            // Log the error message
            Log::error($exception);
            // Log::info(env('SEND_ERROR_MAIL'));

            $this->sendErrorEmail($exception);


            // Return a 500 error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
