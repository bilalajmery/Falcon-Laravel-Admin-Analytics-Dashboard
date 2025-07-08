<?php

namespace App\Http\Middleware;

use App\Http\Controllers\commonFunction;
use App\Models\RequestLogs;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Support\Facades\Response;

class storeRequestLogs extends commonFunction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $startTime = microtime(true);
        $response = $next($request);
        $endTime = microtime(true);
        $responseTime = round(($endTime - $startTime) * 1000, 2);
        $modifiedPath = preg_replace('#^api/v1#', '', $request->path());

        RequestLogs::create([
            'ipAddress' => $request->ip(),
            'endPoint' => $modifiedPath,
            'method' => $request->method(),
            'status' => $response->status(),
            'responseTime' => $responseTime,
        ]);

        return $response;
    }
}
