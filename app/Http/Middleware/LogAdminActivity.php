<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && auth()->user()->isAdmin()) {
            $method = $request->method();
            
            if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $action = match($method) {
                    'POST' => 'create',
                    'PUT', 'PATCH' => 'update',
                    'DELETE' => 'delete',
                    default => strtolower($method)
                };
                
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => $action,
                    'description' => auth()->user()->name . " performed {$action} on " . $request->path(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $method
                ]);
            }
        }

        return $response;
    }
}